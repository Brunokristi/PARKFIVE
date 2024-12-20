<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use App\Models\Bed;
use App\Models\Feature;
use App\Models\RoomImage;
use Illuminate\Support\Facades\Log;
use Google\Client;
use Google\Service\Calendar;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventCreated;
use App\Models\User;


class BookingController extends Controller
{

    public function index()
    {
        return view('bookings');
    }

    public function getRooms(Request $request)
    {
        $request->validate([
            'arrival' => 'required|date|after_or_equal:today',
            'departure' => 'required|date|after:arrival',
            'guests' => 'required|integer|min:1',
        ]);

        $arrival = $request->input('arrival');
        $departure = $request->input('departure');
        $guests = $request->input('guests');

        $keyFilePath = env('GOOGLE_APPLICATION_CREDENTIALS', storage_path('app/credentials.json'));

        $client = new Client();
        $client->setAuthConfig($keyFilePath);
        $client->addScope(Calendar::CALENDAR_READONLY);

        $service = new Calendar($client);

        $calendarIdsApt1 = [
            '4ao7jf4th85a6drtjfsl8knaf79hvu9o@import.calendar.google.com',
            'fea04fdb7d521fe8d9e33bb4a13659a6e27fef0f9d724ce1dca5b51659e96bd8@group.calendar.google.com',
        ];

        $calendarIdsApt2 = [
            '6lglv41endm9auti5slcnmss9n7p72cr@import.calendar.google.com',
            'e8c14f73fe62415e5a831ec552cdbd6a54f25230c155a623f8ae7632c34a627c@group.calendar.google.com',
        ];

         // Fetch unavailable dates
        $unavailableApt1 = $this->fetchUnavailableDates($service, $calendarIdsApt1, $arrival, $departure);
        $unavailableApt2 = $this->fetchUnavailableDates($service, $calendarIdsApt2, $arrival, $departure);


        Log::info('Unavailable Dates for Apartment 1: ' . json_encode($unavailableApt1));
        Log::info('Unavailable Dates for Apartment 2: ' . json_encode($unavailableApt2));

        // Determine Availability
        $unavailableRoomIds = [];

        if (!empty($unavailableApt1)) {
            $unavailableRoomIds[] = 14;
        }

        if (!empty($unavailableApt2)) {
            $unavailableRoomIds[] = 15;
        }

        Log::info('Unavailable Room IDs: ' . implode(', ', $unavailableRoomIds));

        // Query Rooms Excluding Unavailable Ones
        $query = Room::with(['beds', 'features', 'images'])
            ->whereNotIn('id', $unavailableRoomIds)
            ->where('guests', '>=', $guests);

        $rooms = $query->get();

        $rooms = $rooms->map(function ($room) {
            $roomBeds = $room->beds->groupBy('id')->map(function ($group) {
                return $group->count(); // Count occurrences of each bed type
            });

            // Create a grouped list of beds with their quantities
            $room->bed_details = $room->beds->unique('id')->map(function ($bed) use ($roomBeds) {
                return [
                    'id' => $bed->id,
                    'name' => $bed->name,
                    'quantity' => $roomBeds[$bed->id] ?? 0,
                ];
            });

            return $room;
        });

        $beds = DB::table('beds')->get();
        $features = DB::table('features')->get();

        // Return to the View
        return view('bookings', [
            'beds' => $beds,
            'features' => $features,
            'rooms' => $rooms,
            'arrival' => $arrival,
            'departure' => $departure,
            'guests' => $guests,
        ]);
    }

    private function fetchUnavailableDates($service, $calendarIds, $arrival, $departure)
    {
        $unavailableDates = [];

        foreach ($calendarIds as $calendarId) {
            $events = $service->events->listEvents($calendarId, [
                'timeMin' => date('c', strtotime($arrival)),
                'timeMax' => date('c', strtotime($departure)),
                'singleEvents' => true,
                'orderBy' => 'startTime',
            ])->getItems();

            foreach ($events as $event) {
                $eventStart = $event->start->dateTime ?? $event->start->date;
                $eventEnd = $event->end->dateTime ?? $event->end->date;

                // Check for overlap
                if (
                    ($eventStart < $departure) && 
                    ($eventEnd > $arrival)
                ) {
                    $unavailableDates[] = $event;
                }
            }
        }

        return $unavailableDates;
    }

    public function store(Request $request)
    {
        // 1. Validate the form input
        $validated = $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'room_id' => 'required|integer',
            'arrival' => 'required|date',
            'departure' => 'required|date',
            'guests' => 'required|integer',
            'total_cost' => 'required|numeric',
        ]);

        // save the user data
        $user = new User();
        $user->name = $validated['name'] . ' ' . $validated['surname']; 
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->street = $validated['address'];
        $user->city = $validated['city'];
        $user->zip_code = $validated['zip'];
        $user->save();

        // save the booking data
        $booking = new Booking();
        $booking->user_id = $user->id;
        $booking->check_in_date = $validated['arrival'];
        $booking->check_out_date = $validated['departure'];
        $booking->total_price = $validated['total_cost'];
        $booking->save();

        // assign the room to the booking
        $booking->rooms()->attach($validated['room_id']);

        // 2. Create a Google Calendar event
        $this->createGoogleCalendarEvent($validated);
        Mail::to($validated['email'])->send(new EventCreated($validated));

        // 3. Create a Stripe Checkout Session
        $stripeSession = $this->createStripeSession($validated['total_cost']);

        // 4. Redirect to Stripe Checkout
        return redirect($stripeSession->url);
    }

    private function createGoogleCalendarEvent($data)
    {
        $roomId = $data['room_id'];
        $arrival = $data['arrival'];
        $departure = $data['departure'];
        $guests = $data['guests'];
        $totalCost = $data['total_cost'];

        // Fetch room details
        $room = Room::findOrFail($roomId);

        $keyFilePath = env('GOOGLE_APPLICATION_CREDENTIALS', storage_path('app/credentials.json'));

        $client = new \Google_Client();
        $client->setAuthConfig($keyFilePath);
        $client->addScope(\Google_Service_Calendar::CALENDAR);

        $service = new \Google_Service_Calendar($client);

        $event = new \Google_Service_Calendar_Event([
            'summary' => 'Reservation ' . $room->name,
            'location' => 'Parková 5, 984 01 Lučenec, Slovakia',
            'description' => "Rezervácia pre {$guests} hostí.",
            'start' => [
                'date' => $arrival,
                'timeZone' => 'Europe/Bratislava',
            ],
            'end' => [
                'date' => $departure,
                'timeZone' => 'Europe/Bratislava',
            ],
        ]);

        // Assign calendar ID based on room ID
        $calendarIds = [
            14 => 'fea04fdb7d521fe8d9e33bb4a13659a6e27fef0f9d724ce1dca5b51659e96bd8@group.calendar.google.com',
            15 => 'e8c14f73fe62415e5a831ec552cdbd6a54f25230c155a623f8ae7632c34a627c@group.calendar.google.com',
        ];

        $calendarId = $calendarIds[$roomId] ?? null;

        if (!$calendarId) {
            Log::error('Calendar ID not found for room ID: ' . $roomId);
            return view('homepage');
        }

        try {
            $createdEvent = $service->events->insert($calendarId, $event);
        } catch (Exception $e) {
            Log::error('Error creating event: ' . $e->getMessage());
        }
    }

    private function createStripeSession($totalCost)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Rezervácia izby',
                    ],
                    'unit_amount' => $totalCost * 100, // Convert to cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('bookings.success'),
            'cancel_url' => route('bookings.cancel'),
        ]);
    }

    public function toPay(Request $request)
    {
        $request->validate([
            'room_name' => 'required|string',
            'arrival' => 'required|date|after_or_equal:today',
            'departure' => 'required|date|after:arrival',
            'guests' => 'required|integer|min:1',
            'room_id' => 'required|exists:rooms,id',
            'total_cost' => 'required|numeric|min:0',
        ]);

        $roomName = $request->input('room_name');
        $arrival = $request->input('arrival');
        $departure = $request->input('departure');
        $guests = $request->input('guests');
        $roomId = $request->input('room_id');
        $totalCost = $request->input('total_cost');

        return view('payment', [
            'room_name' => $roomName,
            'arrival' => $arrival,
            'departure' => $departure,
            'guests' => $guests,
            'room_id' => $roomId,
            'total_cost' => $totalCost,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
