
document.addEventListener('DOMContentLoaded', function () {
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

                    console.log('Room Data:', data.images);

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
                        bedsContainer.innerHTML += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="beds[]" value="${bed.id}" id="bed${bed.id}" ${bed.selected ? 'checked' : ''}>
                            <label class="form-check-label" for="bed${bed.id}">${bed.name}</label>
                        </div>`;
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
});

