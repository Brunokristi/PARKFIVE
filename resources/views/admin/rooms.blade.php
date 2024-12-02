<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Izby</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/room.js')
    <style>
        .color-picker {
            width: 100%;
        }
    </style>

</head>

<body class="bg-light">
    <div class="container my-5">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4">Izby</h1>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRoom" id="createNewButton">
                Pridať izbu
            </button>        
        </div>

        

        <!-- Table Section -->
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col">Názov</th>
                    <th scope="col">Opis</th>
                    <th scope="col">Cena</th>
                    <th scope="col" class="text-end"></th>
                </tr>
            </thead>
            <tbody>
                @if ($rooms->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">Žiadne izby neboli nájdené.</td>
                    </tr>
                @else
                    @foreach ($rooms as $room)
                    <tr>
                        <td>{{ $room->name }}</td>
                        <td>{{ $room->description }}</td>
                        <td>{{ $room->price_per_night }}</td>
                        <td class="text-end">
                            <button type="button" 
                                    class="btn btn-sm btn-secondary me-2 edit-room-button" 
                                    data-bs-toggle="modal" 
                                    data-room-id="{{ $room->id }}" 
                                    data-bs-target="#editRoom">
                                Upraviť
                            </button>
                            <button type="button" 
                                    class="btn btn-sm btn-danger delete-button" 
                                    data-bs-toggle="modal" 
                                    data-room-id="{{ $room->id }}" 
                                    data-bs-target="#deleteConfirmationModal">
                                Vymazať
                            </button>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>


    <div class="modal fade" id="editRoom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editRoomLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editRoomLabel">Upraviť izbu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editRoomForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                        <div class="mb-3">
                            <label for="editRoomName" class="form-label">Názov</label>
                            <input type="text" class="form-control" id="editRoomName" name="room_name" maxlength="100" required>
                            <small id="editRoomNameCounter" class="form-text text-muted">0 / 100 znakov</small>
                        </div>

                        <div class="mb-3">
                            <label for="editRoomDescription" class="form-label">Popis</label>
                            <textarea class="form-control" id="editRoomDescription" name="room_description" rows="3" maxlength="255" required></textarea>
                            <small id="editRoomDescriptionCounter" class="form-text text-muted">0 / 255 znakov</small>
                        </div>


                        <hr>


                        <div class="mb-3">
                            <label class="form-label">Obrázky izby</label>
                            <div id="editRoomImages" class="d-flex flex-wrap gap-2">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newRoomImages" class="form-label">Pridať nové obrázky</label>
                            <input class="form-control" type="file" id="newRoomImages" name="images[]" multiple>
                        </div>


                        <hr>

                        <div class="mb-3">
                            <label for="editRoomPrice" class="form-label">Cena</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="editRoomPrice" name="price" required>
                                <span class="input-group-text">€</span>
                        </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="editRoomCount" class="form-label">Počet izieb</label>
                                <input type="number" class="form-control" id="editRoomCount" name="room_count" min="1" required>
                            </div>

                            <div class="col">
                                <label for="editRoomColor" class="form-label">Farba tokenu</label>
                                <input type="color" class="form-control form-control-color" id="editRoomColor" name="token_color" required>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="editRoomGuests" class="form-label">Max. počet osôb</label>
                            <input type="number" class="form-control" id="editRoomGuests" name="max_guests" min="1" required>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Lôžka</label>
                                <div id="editBeds">
                                    <!-- Beds will be populated dynamically -->
                                </div>
                            </div>

                            <div class="col mb-3">
                                <label class="form-label">Iné služby</label>
                                <div id="editFeatures">
                                    <!-- Features will be populated dynamically -->
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationLabel">Potvrdiť vymazanie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Ste si istý, že chcete vymazať túto izbu? Táto akcia je nevratná.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušiť</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Vymazať</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newRoom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Vytvoriť novú izbu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">



                    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="roomName" class="form-label">Názov</label>
                            <input type="text" class="form-control" id="roomName" name="room_name" maxlength="100" required>
                            <small id="roomNameCounter" class="form-text text-muted">0 / 100 znakov</small>
                        </div>

                        <!-- Description Field with Character Counter -->
                        <div class="mb-3">
                            <label for="roomDescription" class="form-label">Popis</label>
                            <textarea class="form-control" id="roomDescription" name="room_description" rows="3" maxlength="255" required></textarea>
                            <small id="roomDescriptionCounter" class="form-text text-muted">0 / 255 znakov</small>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label">Prezentačné obrázky</label>
                            <input class="form-control" type="file" id="formFileMultiple" name="images[]" multiple required>
                        </div>

                        <div class="mb-3">
                            <label for="formLayoutImage" class="form-label">Fotka rozloženia</label>
                            <input class="form-control" type="file" id="formLayoutImage" name="layout_image" required>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="roomPrice" class="form-label">Cena</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="roomPrice" name="price" required>
                                <span class="input-group-text">€</span>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="roomCount" class="form-label">Počet izieb</label>
                                <input type="number" class="form-control" id="roomCount" name="room_count" min="1" required>
                            </div>
                            <div class="col">
                                <label for="tokenColor" class="form-label">Farba tokenu</label>
                                <input type="color" class="form-control form-control-color color-picker" id="tokenColor" name="token_color" value="#563d7c" required>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="maxGuests" class="form-label">Max. počet osôb na izbu</label>
                                <input type="number" class="form-control" id="maxGuests" name="max_guests" min="1" required>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Lôžka</label>
                                @foreach ($beds as $bed)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="beds[]" value="{{ $bed->id }}" id="bed{{ $bed->id }}">
                                    <label class="form-check-label" for="bed{{ $bed->id }}">
                                        {{ $bed->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            <div class="col mb-3">
                                <label class="form-label">Iné služby</label>
                                @foreach ($features as $feature)
                                <div class="form-check">
                                    <input class="form-check-input feature" type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature{{ $feature->id }}">
                                    <label class="form-check-label" for="feature{{ $feature->id }}">
                                        {{ $feature->name }}
                                    </label>
                                </div>
                                @endforeach
                                <button type="button" class="btn btn-secondary mt-3" id="selectAll">Označiť všetko</button>
                            </div>
                        </div>

                        <hr>

                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
