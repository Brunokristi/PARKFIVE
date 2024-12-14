<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Príbehy - ubytovanie Lučenec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    <style>
       body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            color: #fff;
            font-weight: 300;
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #B19D9C;
            padding: 20px;
        }

        .story-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 90%;
            max-width: 1200px;
            height: 100%;
            overflow: hidden;
        }

        .story-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px; 
            width: 100%;
            height: 100%;
            overflow: hidden;
            scroll-behavior: smooth;
        }

        .story {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: all 0.5s ease;
            position: relative;
        }

        .story.half-active {
            display: flex;
            width: 25%;
            height: 60vh;
            opacity: 0.7;
            transform: scale(0.9);
            border-radius: 50px;
        }

        .story.active {
            display: flex;
            width: 40%;
            height: 70vh; /* Make the active story fully visible */
            z-index: 10;
            opacity: 1;
            transform: scale(1);
            align-self: center; /* Center it vertically */
        }

        .story img {
            width: 100%;
            height: 100%;
            border-radius: 50px;
            object-fit: cover;
            transition: opacity 0.5s, transform 0.5s ease;
        }

        .story.active img {
            transform: scale(1.05);
        }

        .arrow {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 24px;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .arrow.left {
            left: -50px;
        }

        .arrow.right {
            right: -50px;
        }

        .arrow:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .story-caption {
            padding: 15px;
        }

    </style>
</head>
        <body>
            <div class="story-container">
                <button class="arrow left">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <div class="story-wrapper">
            <div class="story">
                <img src="{{ asset('images/story_grass.jpg') }}" alt="Príroda">
                <div class="story-caption">Príroda</div>
            </div>
            <div class="story active">
                <img src="{{ asset('images/story_bikes.jpg') }}" alt="Bicykle">
                <div class="story-caption">Bicykle</div>
            </div>
            <div class="story">
                <img src="{{ asset('images/story_water.jpg') }}" alt="Pri vode">
                <div class="story-caption">Pri vode</div>
            </div>
            <div class="story">
                <img src="{{ asset('images/story_history.jpg') }}" alt="História">
                <div class="story-caption">História</div>
            </div>
            <div class="story">
                <img src="{{ asset('images/story_parkfive.jpg') }}" alt="Parkfive">
                <div class="story-caption">Parkfive</div>
            </div>
        </div>


        <button class="arrow right">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const stories = document.querySelectorAll(".story");
        const leftArrow = document.querySelector(".arrow.left");
        const rightArrow = document.querySelector(".arrow.right");
        let activeIndex = @json($activeStory);

        activeIndex = activeIndex - 1;
        const updateActiveStory = (newIndex) => {
            // Clear previous states
            stories.forEach(story => {
                story.classList.remove("active", "half-active");
                story.style.display = "none";
            });

            // Update active story
            activeIndex = newIndex;
            stories[activeIndex].style.display = "flex";
            stories[activeIndex].classList.add("active");

            // Show only the previous and next stories
            const prevIndex = activeIndex - 1 >= 0 ? activeIndex - 1 : null;
            const nextIndex = activeIndex + 1 < stories.length ? activeIndex + 1 : null;

            if (prevIndex !== null) {
                stories[prevIndex].style.display = "flex";
                stories[prevIndex].classList.add("half-active");
            }

            if (nextIndex !== null) {
                stories[nextIndex].style.display = "flex";
                stories[nextIndex].classList.add("half-active");
            }

            // Enable/Disable arrows based on the active index
            leftArrow.style.visibility = activeIndex > 0 ? "visible" : "hidden";
            rightArrow.style.visibility = activeIndex < stories.length - 1 ? "visible" : "hidden";
        };

        // Left arrow click event
        leftArrow.addEventListener("click", () => {
            if (activeIndex > 0) {
                updateActiveStory(activeIndex - 1);
            }
        });

        // Right arrow click event
        rightArrow.addEventListener("click", () => {
            if (activeIndex < stories.length - 1) {
                updateActiveStory(activeIndex + 1);
            }
        });

        // Initialize the slider
        updateActiveStory(activeIndex);
    });
    </script>
    </body>
</html>
