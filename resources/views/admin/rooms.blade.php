<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izby</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .color-picker {
            width: 100%; /* Makes the color input full width */
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="createNewButton">
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
                    <th scope="col">Akcie</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Apartmán 1</td>
                    <td>Lorem Ipsum is simply dummy text of the printing...</td>
                    <td>50€</td>
                    <td>
                        <button class="btn btn-sm btn-secondary me-2">upraviť</button>
                        <button class="btn btn-sm btn-danger">vymazať</button>
                    </td>
                </tr>
                <tr>
                    <td>Apartmán 2</td>
                    <td>Lorem Ipsum is simply dummy text of the printing...</td>
                    <td>50€</td>
                    <td>
                        <button class="btn btn-sm btn-secondary me-2">upraviť</button>
                        <button class="btn btn-sm btn-danger">vymazať</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <input type="number" class="form-control" id="roomCount" name="room_count" required>
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
                                <input type="number" class="form-control" id="maxGuests" name="max_guests" required>
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

        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <!-- Success Message -->
            @if (session('success'))
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Success</strong>
                        <small class="text-muted">just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Warning</strong>
                            <small class="text-muted">just now</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            {{ $error }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</body>

<script>
    const roomNameInput = document.getElementById('roomName');
    const roomNameCounter = document.getElementById('roomNameCounter');

    roomNameInput.addEventListener('input', () => {
        roomNameCounter.textContent = `${roomNameInput.value.length} / ${roomNameInput.maxLength} znakov`;
    });

    const roomDescriptionInput = document.getElementById('roomDescription');
    const roomDescriptionCounter = document.getElementById('roomDescriptionCounter');

    roomDescriptionInput.addEventListener('input', () => {
        roomDescriptionCounter.textContent = `${roomDescriptionInput.value.length} / ${roomDescriptionInput.maxLength} znakov`;
    });

    function randomcolor() {
        return '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');
    }

    const button = document.getElementById('createNewButton');

    button.addEventListener('click', () => {
        const roomColor = document.getElementById('exampleColorInput');
        roomColor.value = randomcolor();

        const checkboxes = document.querySelectorAll('.form-check-input');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = false;
        });
    });

    var checked = false;

    document.getElementById('selectAll').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.feature');
        checked = !checked;
        checkboxes.forEach((checkbox) => {
            checkbox.checked = checked;
        });
    });

</script>

</html>