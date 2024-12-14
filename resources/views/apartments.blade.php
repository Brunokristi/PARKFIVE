<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartmány - ubytovanie Lučenec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            color: #B89080;
            font-weight: 300;
            font-size: 16px;
        }

        .main {
            padding: 20px;
            padding-top: 80px;
        }

        h1, h2 {
            font-size: 30px;
            margin-bottom: 20px;
            color: #B19D9C;
            font-family: 'Gotu', sans-serif;
            font-weight: 100;
        }

        h2 {
            font-size: 24px;
            color: #fff;
        } 

        .container {
            margin: 0;
            padding: 0;
            width: 100%;
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .section{
            display: flex;
            justify-content: space-between;
        }

        .column {
            width: 32%;
            height: 500px;
            background-color: #fff;
            border-radius: 50px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            border: solid 1px #B89080;
            color: #fff;
        }
        
        .column p {
            font-size: 18px;
            margin: 20;
        }

        .slider-container {
            width: 100%;
            height: 100%;
            position: relative;
        }   

        .thumbnail {
            width: auto;
            height: 90%;
            border-radius: 50px;
            border: none;
        }


        .arrow-left,
        .arrow-right {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 24px;
            z-index: 10;
            color: #B89080; 
            cursor: pointer;
        }

        .arrow-left {
            left: 10px;
        }

        .arrow-right {
            right: 10px;
        }

        .column:first-child {
            background-color: #B89080;
            display: block;
            padding: 20px;
            text-align: center;
            overflow: auto;
            scrollbar-width: thin;
            scrollbar-color: #fff rgba(0, 0, 0, 0.0);
        }

        .column:first-child::-webkit-scrollbar {
            width: 8px; 
        }

        .column:first-child::-webkit-scrollbar-track {
            background: #F5F5F5; /* Background color of the scrollbar track */
            border-radius: 10px; /* Optional: Round corners */
        }

        .column:first-child::-webkit-scrollbar-thumb {
            background: #FFF; /* Scrollbar thumb color */
            border-radius: 10px; /* Optional: Round corners */
        }

        .column:first-child::-webkit-scrollbar-thumb:hover {
            background: #FFF; /* Scrollbar thumb color on hover */
        }

        .column:nth-child(2) {
            border: none;
        }

        .group {
            border: solid 1px #fff;
            border-radius: 50px;
            padding: 20px;
            margin-top: 20px;
        }


    </style>
</head>
<body>

    <div class="main">
        @foreach ($rooms as $room)
            <div class="container">
                <h1>{{ $room->name }}</h1>
                <div class="section">
                    <div class="column">
                        <h2>1 - {{ $room-> guests}} osôb</h2>

                        <div class="group">
                            <h2>Lôžka</h2>
                            @foreach ($room->beds as $bed)
                                <hr>
                                <p>{{ $bed->name }}: {{ $bed->count }}</p>
                            @endforeach
                        </div>

                        <div class="group">
                            <h2>Služby</h2>
                            @foreach ($room->features as $facility)
                                <hr>
                                <p>{{ $facility->name }}</p>
                            @endforeach
                        </div>


                    </div>

                    <div class="column">
                        <i class="bi bi-chevron-left arrow-left" style="cursor: pointer;"></i>
                        <div class="slider-container" id="slider-container-{{ $room->id }}">
                        </div>
                        <i class="bi bi-chevron-right arrow-right" style="cursor: pointer;"></i>
                    </div>

                    <div class="column">
                        @if ($room->images && $room->images->count() > 0)
                            @foreach ($room->images->where('type', 'layout') as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Room Layout" class="thumbnail">
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <hr>
        @endforeach

    </div>
    @include('components.navbar')
    @include('components.booking')
    @include('components.footer')



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        // Fetch room data from Blade
        const rooms = @json($rooms);

        rooms.forEach((room) => {
            const sliderContainer = document.getElementById(`slider-container-${room.id}`);
            const images = room.images.filter(image => image.type === 'image');

            images.forEach((image, index) => {
                const img = document.createElement('img');
                img.src = `/storage/${image.image_path}`;
                img.alt = `Room Layout ${image.id}`;
                img.classList.add('slider-image');
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.borderRadius = '50px';
                img.style.objectFit = 'cover';
                img.style.display = index === 0 ? 'block' : 'none'; // Show only the first image initially
                sliderContainer.appendChild(img);
            });

            // Arrow functionality for the current room
            const leftArrow = sliderContainer.previousElementSibling; // Left arrow
            const rightArrow = sliderContainer.nextElementSibling; // Right arrow
            const sliderImages = sliderContainer.querySelectorAll('.slider-image');
            let currentIndex = 0;

            const updateImage = (newIndex) => {
                sliderImages[currentIndex].style.display = 'none'; // Hide current image
                currentIndex = newIndex; // Update current index
                sliderImages[currentIndex].style.display = 'block'; // Show new image
            };

            // Left arrow click event
            leftArrow.addEventListener('click', () => {
                const newIndex = (currentIndex - 1 + sliderImages.length) % sliderImages.length;
                updateImage(newIndex);
            });

            // Right arrow click event
            rightArrow.addEventListener('click', () => {
                const newIndex = (currentIndex + 1) % sliderImages.length;
                updateImage(newIndex);
            });
        });
    });
    </script>

</body>
</html>