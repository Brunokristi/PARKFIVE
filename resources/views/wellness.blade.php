<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wellness a Bazén</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #B89080;
            font-weight: 300;
        }

        .main {
            display: flex; 
            width: 100vw; 
            height: 100vh;
            overflow: hidden;
            padding: 20px;
        }

        h1 {
            font-size: 30px;
            margin-bottom: 20px;
            color: #B19D9C;
            font-family: 'Gotu', sans-serif;
            font-weight: 100;
            text-align: center;
        }

        .column {
            width: 50vw;
            height: 100vh;
        }

        .column.first {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .column.second {
            display: flex;
            flex-direction: row;
            overflow-y: auto;
            padding-bottom: 150px;
        }

        .minicolumn {
            width: 50%;
            height: 100%;
            padding-bottom: 150px;
        }

        .minicolumn:last-child {
            margin-top: 50px;
        }

        .img-container {
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .img-container img {
            width: 100%;
            height: auto;
            border-radius: 50px;
        }

        .img-container a {
            position: absolute;
            bottom: 30px; 
            left: 50%;
            transform: translateX(-50%);
            background-color: #fff;
            color: #000;
            font-size: 20px;
            font-weight: 300;
            border-radius: 50px;
            text-decoration: none;
            width: 70%;
            text-align: center;
            padding: 10px 0;
        }


    </style>
</head>
<body>
    <div class="main">
        <div class="column first">
            <h1>Užite si víkend bez stresu.</h1>
        </div>

        <div class="column second">
            <div class="minicolumn">
                <div class="img-container">
                    <img src="{{ asset('images/wellness_pool.jpg') }}" alt="">
                    <a>Bazén s protiprúdom</a>
                </div>

                <div class="img-container">
                    <img src="{{ asset('images/story_history.jpg') }}" alt="">
                    <a>Bazén s protiprúdom</a>
                </div>

                <div class="img-container">
                    <img src="{{ asset('images/story_grass.jpg') }}" alt="">
                    <a>Bazén s protiprúdom</a>
                </div>
            </div>


            <div class="minicolumn">
                <div class="img-container">
                    <img src="{{ asset('images/story_grass.jpg') }}" alt="">
                    <a>Bazén s protiprúdom</a>
                </div>

                <div class="img-container">
                    <img src="{{ asset('images/story_grass.jpg') }}" alt="">
                    <a>Bazén s protiprúdom</a>
                </div>

                <div class="img-container">
                    <img src="{{ asset('images/story_grass.jpg') }}" alt="">
                    <a>Bazén s protiprúdom</a>
                </div>
            </div>

        </div>
    </div>

    @include('components.navbar')
    @include('components.booking')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const firstColumn = document.querySelector('.column.first');
        const secondColumn = document.querySelector('.column.second');

        firstColumn.addEventListener('wheel', (event) => {
            secondColumn.scrollBy({
                top: event.deltaY,
            });

            event.preventDefault();
        });
    });
</script>
</body>
</html>
