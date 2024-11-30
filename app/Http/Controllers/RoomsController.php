<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use Illuminate\Support\Facades\Log;



class RoomsController extends Controller
{
    public function index()
    {
        $beds = DB::table('beds')->get();
        $features = DB::table('features')->get();
        $rooms = Room::with(['beds', 'features', 'images'])->get();
        return view('admin.rooms', ['beds' => $beds, 'features' => $features, 'rooms' => $rooms]);
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

}


