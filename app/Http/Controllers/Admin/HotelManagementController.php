<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelPageContent;
use App\Services\Admin\HotelEditorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelManagementController extends Controller
{
    public function __construct(private readonly HotelEditorService $editor)
    {
    }

    public function index(Request $request): View
    {
        $hotel = $this->editor->getPrimaryHotel();

        return view('admin.dashboard', [
            'hotel' => $hotel,
            'settings' => $this->editor->exportHotelSettings($hotel),
            'pageContentsJson' => $this->editor->encodeJson($this->editor->exportPageContents($hotel)),
            'propertyJson' => $this->editor->encodeJson($this->editor->exportPropertyContent($hotel)),
            'pageKeys' => HotelPageContent::query()
                ->where('hotel_id', $hotel->id)
                ->select('page_key')
                ->distinct()
                ->orderBy('page_key')
                ->pluck('page_key'),
            'adminUser' => $request->user(),
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $hotel = $this->editor->getPrimaryHotel();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'domains' => ['required', 'string'],
        ]);

        $this->editor->saveHotelSettings($hotel, $data);

        return back()->with('status', 'Hotel settings saved.');
    }

    public function updatePages(Request $request): RedirectResponse
    {
        $hotel = $this->editor->getPrimaryHotel();

        $data = $request->validate([
            'pages_json' => ['required', 'string'],
        ]);

        $this->editor->savePageContentsFromJson($hotel, $data['pages_json']);

        return back()->with('status', 'Page content saved.');
    }

    public function updateProperty(Request $request): RedirectResponse
    {
        $hotel = $this->editor->getPrimaryHotel();

        $data = $request->validate([
            'property_json' => ['required', 'string'],
        ]);

        $this->editor->savePropertyContentFromJson($hotel, $data['property_json']);

        return back()->with('status', 'Property content saved.');
    }
}