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
            min-height: 100vh;
            background-color: #B19D9C;
            padding: 20px;
        }

        .bi {
            color: #fff;
        }

        .story-container {
            position: relative;
            display: flex;
            align-items: center;
            width: 90%;
            max-width: 1200px;
        }

        .story-wrapper {
            display: flex;
            justify-content: center;
            gap: 20px;
            overflow: hidden;
            width: 100%;
            scroll-behavior: smooth;
            align-items: center;
        }

        .story {
            border-radius: 20px;
            text-align: center;
            overflow: hidden;
            position: relative;
            width: 30%;
            height: 65vh;
            transition: all 0.5s ease;
            display: flex;
            flex-direction: column;
        }

        .story img {
            width: 100%;
            height: 100%;
            border-radius: 20px;
            object-fit: cover;
            transition: opacity 0.5s, transform 0.5s ease;
            opacity: 0.5;
            padding: 10px;
            margin-bottom: 10px;
        }

        .story.active {
            height: 75vh;
            width: 40%;
            margin-bottom: 10px;
        }

        .story.active img {
            opacity: 1;
            transform: scale(1.05);
        }

        .arrow {
            background-color: transparent;
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
            position: absolute;
            left: -50px;
        }

        .arrow.right {
            position: absolute;
            right: -50px;
        }

        .arrow:hover {
            background-color: rgba(255, 255, 255, 0.2);
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
                <img src="images/story_grass.jpg" alt="Príroda">
                <div class="story-caption">príroda</div>
            </div>
            <div class="story active">
                <img src="images/story_history.jpg" alt="História">
                <div class="story-caption">história</div>
            </div>
            <div class="story">
                <img src="images/story_bikes.jpg" alt="Bicykle">
                <div class="story-caption">bicykle</div>
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

    </body>
</html>
