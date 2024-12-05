<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\Bed;
use App\Models\Feature;
use App\Models\RoomImage;
use Illuminate\Support\Facades\Log;



class RoomsController extends Controller
{
    public function index(Request $request)
    {
        // Initialize the query for Room
        $query = Room::with(['beds', 'features', 'images']);

        // Apply search filters
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('price_per_night', 'like', "%{$search}%");
        }

        // Execute the query
        $rooms = $query->get();

        // Fetch additional data
        $beds = DB::table('beds')->get();
        $features = DB::table('features')->get();

        // Return the view with data
        return view('admin.rooms', [
            'beds' => $beds,
            'features' => $features,
            'rooms' => $rooms,
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Request Data:', $request->all());

        $validated = $request->validate([
            'room_name' => 'required|string|max:100',
            'room_description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'room_count' => 'required|integer',
            'token_color' => 'required|string',
            'max_guests' => 'required|integer',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg',
            'layout_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'beds' => 'nullable|array',
            'beds.*' => 'integer|exists:beds,id',
            'features' => 'nullable|array',
            'features.*' => 'integer|exists:features,id',
        ]);

        // Create the room
        $room = Room::create([
            'name' => $validated['room_name'],
            'description' => $validated['room_description'],
            'price_per_night' => $validated['price'],
            'ammount' => $validated['room_count'],
            'color' => $validated['token_color'],
            'guests' => $validated['max_guests'],
        ]);

        if (!empty($validated['features'])) {
            $room->features()->attach($validated['features']);
        }

        if (!empty($validated['beds'])) {
            $room->beds()->attach($validated['beds']);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('rooms/images', 'public');
                DB::table('room_images')->insert([
                    'room_id' => $room->id,
                    'image_path' => $path,
                    'type' => 'image', // Set type as needed
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        if ($request->hasFile('layout_image')) {
            $layoutPath = $request->file('layout_image')->store('rooms/layouts', 'public');
            DB::table('room_images')->insert([
                'room_id' => $room->id,
                'image_path' => $layoutPath,
                'type' => 'layout',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Room created successfully!');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id); // Find the room by ID
        $room->delete(); // Delete the room

        return response()->json(['success' => true, 'message' => 'Room deleted successfully!']);
    }

    public function edit($id)
    {
        $room = Room::with(['beds', 'features', 'images'])->findOrFail($id);

        // Attach `selected` attribute to beds and features
        $beds = Bed::all()->map(function ($bed) use ($room) {
            $bed->selected = $room->beds->contains($bed->id);
            return $bed;
        });

        $features = Feature::all()->map(function ($feature) use ($room) {
            $feature->selected = $room->features->contains($feature->id);
            return $feature;
        });



        $response = [
            'name' => $room->name,
            'description' => $room->description,
            'price_per_night' => $room->price_per_night,
            'ammount' => $room->ammount,
            'color' => $room->color,
            'guests' => $room->guests,
            'beds' => $beds,
            'features' => $features,
            'images' => $room->images,
        ];

        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validatedData = $request->validate([
            'room_name' => 'required|string|max:100',
            'room_description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'room_count' => 'required|integer|min:1',
            'token_color' => 'required|string',
            'max_guests' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'layouts.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'beds' => 'nullable|array',
            'beds.*' => 'integer|exists:beds,id',
            'features' => 'nullable|array',
            'features.*' => 'integer|exists:features,id',
        ]);

        Log::info('Request Data:', $request->all());

        $room->update([
            'name' => $validatedData['room_name'],
            'description' => $validatedData['room_description'],
            'price_per_night' => $validatedData['price'],
            'ammount' => $validatedData['room_count'],
            'color' => $validatedData['token_color'],
            'guests' => $validatedData['max_guests'],
        ]);

        // Handle new room images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('rooms/images', 'public');
                $room->images()->create(['image_path' => $path, 'type' => 'image']);
            }
        }

        // Handle new layout images
        if ($request->hasFile('layouts')) {
            foreach ($request->file('layouts') as $layout) {
                $path = $layout->store('rooms/layouts', 'public');
                $room->images()->create(['image_path' => $path, 'type' => 'layout']);
            }
        }

        $room->beds()->sync($request['beds'] ?? []);
        $room->features()->sync($request['features'] ?? []);

        return redirect()->back()->with('success', 'Room updated successfully!');
    }
}


