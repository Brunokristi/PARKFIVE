<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\RoomImage; // Adjust if your model name is different

class ImageController extends Controller
{
    public function destroy($id)
    {
        // Find the image by ID
        $image = RoomImage::findOrFail($id); // Adjust if your model name is different

        // Delete the file from storage
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete the database record
        $image->delete();

        // Return a success response
        return response()->json(['success' => 'Image deleted successfully.']);
    }
}
