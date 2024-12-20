
document.addEventListener('DOMContentLoaded', function () {

    //count the number of words
    const roomNameInput = document.getElementById('roomName');
    const roomNameCounter = document.getElementById('roomNameCounter');
    const roomDescriptionInput = document.getElementById('roomDescription');
    const roomDescriptionCounter = document.getElementById('roomDescriptionCounter');

    roomNameInput.addEventListener('input', () => {
        roomNameCounter.textContent = `${roomNameInput.value.length} / ${roomNameInput.maxLength} znakov`;
    });

    roomDescriptionInput.addEventListener('input', () => {
        roomDescriptionCounter.textContent = `${roomDescriptionInput.value.length} / ${roomDescriptionInput.maxLength} znakov`;
    });





    //  New room form
    document.getElementById('createNewButton').addEventListener('click', () => {
        const roomColor = document.getElementById('tokenColor');
        roomColor.value = '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');

        const checkboxes = document.querySelectorAll('.form-check-input');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = false;
        });
    });



    // Select all checkboxes
    let checked = false;
    document.getElementById('selectAll').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.feature');
        checked = !checked;
        checkboxes.forEach((checkbox) => {
            checkbox.checked = checked;
        });
    });



    // Delete room
    let roomIdToDelete = null;



    // Handle delete button click
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            roomIdToDelete = this.dataset.roomId; // Store the room ID for deletion
        });
    });



    // Handle confirmation button click
    document.getElementById('confirmDeleteButton').addEventListener('click', function () {
        if (roomIdToDelete) {
            fetch(`/rooms/${roomIdToDelete}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
                .then(response => {
                    if (response.ok) {
                        // Reload the page or update the table dynamically
                        window.location.reload();
                    } else {
                        console.error('Failed to delete the room.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Hide the modal
        const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
        deleteModal.hide();
    });


    // Edit room
    document.querySelectorAll('.edit-room-button').forEach(button => {
        button.addEventListener('click', function () {
            const roomId = this.dataset.roomId;


            fetch(`/rooms/${roomId}/edit`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
                .then(response => response.json())
                .then(data => {
                    // Populate input fields with fetched data
                    const editRoomName = document.getElementById('editRoomName');
                    const editRoomNameCounter = document.getElementById('editRoomNameCounter');
                    const editRoomDescription = document.getElementById('editRoomDescription');
                    const editRoomDescriptionCounter = document.getElementById('editRoomDescriptionCounter');

                    editRoomName.value = data.name;
                    editRoomDescription.value = data.description;
                    document.getElementById('editRoomPrice').value = data.price_per_night;
                    document.getElementById('editRoomCount').value = data.ammount;
                    document.getElementById('editRoomColor').value = data.color;
                    document.getElementById('editRoomGuests').value = data.guests;


                    const roomImages = document.getElementById('editRoomImages');
                    roomImages.innerHTML = '';
                    const layoutImages = document.getElementById('editRoomLayout');
                    layoutImages.innerHTML = '';

                    data.images.forEach(image => {
                        const imageUrl = `/storage/${image.image_path}`;

                        if (image.type === 'image') {
                            roomImages.innerHTML += `
                            <div class="position-relative">
                                <img src="${imageUrl}" alt="Room Image" class="img-thumbnail" style="width: 100px; height: 100px;">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-image-button" data-image-id="${image.id}">&times;</button>
                            </div>`;
                        }
                        else {
                            layoutImages.innerHTML += `
                            <div class="position-relative">
                                <img src="${imageUrl}" alt="Layout Image" class="img-thumbnail" style="width: 100px; height: 100px;">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-image-button" data-image-id="${image.id}">&times;</button>
                            </div>`;
                        }
                    });

                    // Add event listeners to delete buttons
                    document.querySelectorAll('.delete-image-button').forEach(button => {
                        button.addEventListener('click', function () {
                            const imageId = this.dataset.imageId;

                            fetch(`/images/${imageId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                },
                            })
                                .then(response => response.json())
                                .then(data => {
                                    console.log(data.success);
                                    // Remove the image from the DOM
                                    this.closest('.position-relative').remove();
                                })
                                .catch(error => console.error('Error:', error));
                        });
                    });


                    // Update counters immediately with the fetched values
                    editRoomNameCounter.textContent = `${editRoomName.value.length} / ${editRoomName.maxLength} znakov`;
                    editRoomDescriptionCounter.textContent = `${editRoomDescription.value.length} / ${editRoomDescription.maxLength} znakov`;

                    // Add event listeners for real-time counter updates
                    editRoomName.addEventListener('input', () => {
                        editRoomNameCounter.textContent = `${editRoomName.value.length} / ${editRoomName.maxLength} znakov`;
                    });

                    editRoomDescription.addEventListener('input', () => {
                        editRoomDescriptionCounter.textContent = `${editRoomDescription.value.length} / ${editRoomDescription.maxLength} znakov`;
                    });

                    // Populate beds
                    const bedsContainer = document.getElementById('editBeds');
                    bedsContainer.innerHTML = '';
                    data.beds.forEach(bed => {
                        const bedRow = document.createElement('div');
                        bedRow.classList.add('d-flex', 'bed-row');

                        bedsContainer.innerHTML = `
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Typ lôžka</th>
                                        <th>Počet</th>
                                    </tr>
                                </thead>
                                <tbody id="bedsTableBody">
                                </tbody>
                            </table>
                        `;

                        const bedsTableBody = document.getElementById('bedsTableBody');

                        // Populate the table rows
                        data.beds.forEach(bed => {
                            const bedRow = document.createElement('tr');
                            bedRow.innerHTML = `
                                <td>${bed.name}</td>
                                <td>
                                    <input 
                                        type="number" 
                                        class="form-control form-control-sm bed-quantity" 
                                        name="bed_quantities[${bed.id}][]" 
                                        min="0" 
                                        value="${bed.quantity || 0}" 
                                        id="bed${bed.id}" 
                                        style="width: 100px;"
                                    >
                                </td>
                            `;

                            bedsTableBody.appendChild(bedRow);
                        });
                    });

                    // Populate features
                    const featuresContainer = document.getElementById('editFeatures');
                    featuresContainer.innerHTML = '';
                    data.features.forEach(feature => {
                        featuresContainer.innerHTML += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="features[]" value="${feature.id}" id="feature${feature.id}" ${feature.selected ? 'checked' : ''}>
                            <label class="form-check-label" for="feature${feature.id}">${feature.name}</label>
                        </div>`;
                    });

                    // Update form action
                    document.getElementById('editRoomForm').action = `/rooms/${roomId}`;
                });
        });
    });


    const form = document.getElementById('editRoomForm');
    let priceInput = document.getElementById('editRoomPrice');
    form.addEventListener('submit', function (event) {
        console.log('Form submitted');
        let priceRaw = priceInput.value;
        priceRaw = priceRaw.replace(',', '.');
        priceInput.value = priceRaw;
        const isValidNumber = /^[0-9]+(\.[0-9]{1,2})?$/.test(priceRaw);

        let valid = true;

        if (!isValidNumber || parseFloat(priceRaw) < 0) {
            valid = false;
            alert('Cena za noc je v nesprávnom fomráte.');
        }

        const existingImages = document.getElementById('editRoomImages').querySelectorAll('img').length;
        const existingLayouts = document.getElementById('editRoomLayout').querySelectorAll('img').length;

        const newImages = document.getElementById('newRoomImages').files.length;
        const newLayouts = document.getElementById('newRoomLayouts').files.length;

        if (existingImages === 0 && newImages === 0) {
            valid = false;
            alert('Musíte pridať aspoň jednu fotografiu izby.');
        }

        if (existingLayouts === 0 && newLayouts === 0) {
            valid = false;
            alert('Musíte pridať aspoň jednu fotografiu rozloženia izby.');
        }

        if (existingLayouts + newLayouts > 1) {
            valid = false;
            alert('Fotka rozloženia môže byť iba jedna.');
        }

        const guests = document.getElementById('editRoomGuests');
        const guestsValue = guests.value;

        if (guestsValue < 1) {
            valid = false;
            alert('Počet hostí musí byť aspoň 1.');
        }


        if (!valid) {
            event.preventDefault();
        }
    });
});

