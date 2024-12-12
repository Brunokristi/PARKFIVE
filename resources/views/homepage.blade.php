<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        body {
                margin: 0;
                font-family: 'Inter', sans-serif;
                color: #fff;
                font-weight: 300;
                font-size: 10px;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background-color: #f4f4f4;
                padding: 20px;
                display: block;
            }

            h1 {
                font-size: 30px;
                margin-bottom: 20px;
                color: #fff;
                font-family: 'Gotu', sans-serif;
                font-weight: 100;
            }

            p {
                font-size: 16px;
                margin-bottom: 20px;
                color: #fff;
                font-family: 'Inter', sans-serif;
                font-weight: 300;
            }

            .header {
                display: flex;
                width: 100%;
                height: min-content;
                border-radius: 50px;
                overflow: hidden;
                background-image: url("{{ asset('images/karsten-wurth-mbc6XPuv3Qw-unsplash.jpg') }}");
                background-size: cover;
                background-position: center;
                padding: 0px;
            }


            .navbar-panel {
                padding: 20px;
                width: 30%;
                display: flex;
                flex-direction: column;
            }

            .navbar-panel h1 {
                background-color: #B89080;
                color: #fff;
                padding: 20px;
                border-radius: 50px;
                margin-bottom: 10px;

            }

            .navbar-panel h1 span {
                display: block;
                height: 30px;
                width: 60px;
                border-radius: 50px;
                display: inline-block;
                background-size: cover;
            }

            .navbar-panel h1 span:nth-child(2) {
                background-image: url("{{ asset('images/nature_gif.webp') }}");
            }

            .navbar-panel h1 span:nth-child(5) {
                background-image: url("{{ asset('images/water_gif.webp') }}");
            }

            .navbar-panel .buttons {
                display: flex;
                flex-direction: column;
                font-size: 20px;
            }

            .navbar-panel .buttons a {
                text-decoration: none;
                font-size: 16px;
                background-color: #B89080;
                color: #fff;
                padding: 10px 20px;
                border-radius: 50px;
                margin-bottom: 10px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .navbar-panel .buttons a:hover {
                background-color: #c29c8d;
            }

            .buttons a i{
                font-size: 20px;
                color: #fff
            }



            .stories{
                width: 100%;
                height: min-content;
                border-radius: 50px;
                align-items: center;
                margin-top: 20px;
                padding: 30px;
                background-image: linear-gradient(to bottom right, #B89080, #B19D9C);
            }

            .stories .story-tokens{
                display: flex;
                align-items: center;
            }

            .stories .story{
                width: 100px;
                border-radius: 50%;
                margin-right: 20px;
                text-align: center;    
            }

            .stories .story img{
                height: 100px;
                width: 100px;
                border-radius: 50%;
                object-fit: cover;
                margin-bottom: 10px;
            }

            .stories .story img:hover{
                transform: scale(1.03);
            }

            .stories .story img:hover + p{
                color: #fff;
            }

            .stories .story p{
                color: #D9D9D9;     
            }



        
    </style>
</head>
<body>
    <div class="header">
        <div class="navbar-panel">
            <h1>Apartmány pri <br>
                parku <span> </span> <br>
                s vonkajším <br>
                bazénom <span> </span>
                a wellness
            </h1>
            <div class="buttons">
                <a href="#">
                    izby a apartmány
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="#">
                    aktivity a relax
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="#">
                    wellness
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="#">
                    cenník
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="#">
                    otázky a odpovede
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="stories">
        <h1>Miesto plné zážitkov</h1>
        <div class="story-tokens">
            <div class="story">
                <img src="{{ asset('images/story_grass.jpg') }}" alt="">
                <p>príroda</p>
            </div>

            <div class="story">
                <img src="{{ asset('images/story_bikes.jpg') }}" alt="">
                <p>bicykle</p>
            </div>

            <div class="story">
                <img src="{{ asset('images/story_water.jpg') }}" alt="">
                <p>pri vode</p>
            </div>

            <div class="story">
                <img src="{{ asset('images/story_history.jpg') }}" alt="">
                <p>história</p>
            </div>

            <div class="story">
                <img src="{{ asset('images/story_parkfive.jpg') }}" alt="">
                <p>parkFIVE</p>
            </div>

            <div class="story">
                <img src="{{ asset('images/story_plus.png') }}" alt="">
                <p>pridať</p>
            </div>
        </div>
    </div>

    <div class="section-1">
            
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
