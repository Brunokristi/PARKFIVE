<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkfive - ubytovanie v Lučenci</title>
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
                background-color: #fff;
                display: block;
            }

            .main {
                padding: 20px;
                padding-top: 90px;
            }

            h1 {
                font-size: 25px;
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
                text-decoration: none;
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
                overflow: auto;
            }

            .stories h1 {
                color: #fff;
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

            .stories .story:hover{
                transform: scale(1.03);
            }

            .stories .story img:hover + p{
                color: #fff;
            }

            .stories .story a{
                text-decoration: none;
            }

            .stories .story p{
                color: #D9D9D9;  
            }

            .section-1 {
                display: flex;
                width: 100%;
                margin-top: 20px;
            }

            .section-1 h1 {
                color: #B19D9C;
            }

            .section-1 p {
                color: #B19D9C;                
            }

            .section-1 .text {
                margin-top: 20px;
                width: 30%;
                padding: 20px; 
            }

            .section-1 .layout {
                width: 70%;
                padding: 20px;
            }

            .section-1 .text .fist-section {
                margin-bottom: 120px;
                width: 700px;
            }

            ellipse {
                cursor: pointer;
                transition: transform 0.2s ease;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);

            }

            .tooltip {
                position: absolute;;
                background-color: #fff;
                color: #B19D9C;
                padding: 20px;
                border-radius: 50px;
                font-size: 12px;
                visibility: hidden;
                opacity: 0;
                transition: opacity 0.2s ease;
                pointer-events: auto;                
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                width: 300px;
            }

            .tooltip h3 {
                font-size: 16px;
                margin-bottom: 10px;
                font-family: 'Gotu', sans-serif;
                color: #B89080;
            }

            .tooltip p {
                font-size: 12px;
                font-family: 'Inter', sans-serif;
                color: #B19D9C;
            }

            .tooltip-images {
                margin-top: 10px;
                display: flex;
                overflow-x: scroll;
                width: 100%;
                gap: 10px;
                border-radius: 50px;
            }

            .tooltip img {
                width: 150px;
                height: 200px;
                border-radius: 50px;
                object-fit: cover;
                margin-right: 10px;
            }

            .section-2 {
                display: flex;
                width: 100%;
                margin-top: 20px;
                background-image: linear-gradient(to bottom, #B19D9C, #B89080);
                padding: 20px;
                border-radius: 50px;
            }

            .section-2 .column-1 {
                width: 50%;
                padding: 40px;
            }

            .section-2 h1 {
                color: #fff;
            }

            .section-2 p {
                height: 100px;
            }

            .section-2 .column-2 {
                width: 50%;
                padding: 40px;
            }

            .section-2 a {
                text-decoration: none;
                font-size: 16px;
                background-color: #fff;
                color: #B89080;
                padding: 10px 20px;
                border-radius: 50px;
                margin-top: 10px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .section-2 a i{
                font-size: 20px;
                color: #B89080;
            }

            .section-2 img {
                height: 200px;
                width: 100%;
                border-radius: 50px;
                object-fit: cover;
            }

            .minisection {
                margin-bottom: 20px;
            }
    </style>
</head>
<body>
    <div class="main">
        <div class="header">
            <div class="navbar-panel">
                <h1>Apartmány pri <br>
                    parku <span> </span> <br>
                    s vonkajším <br>
                    bazénom <span> </span>
                    a wellness
                </h1>
                <div class="buttons">
                    <a href="/apartments">
                        izby a apartmány
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="/#trips">
                        aktivity a relax
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="/wellness">
                        wellness
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="faq">
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
                    <a href="{{ route('stories.show', ['id' => 1]) }}">
                        <img src="{{ asset('images/story_grass.jpg') }}" alt="">
                        <p>príroda</p>
                    </a>
                </div>

                <div class="story">
                    <a href="{{ route('stories.show', ['id' => 2]) }}">
                        <img src="{{ asset('images/story_bikes.jpg') }}" alt="">
                        <p>bicykle</p>
                    </a>
                </div>

                <div class="story">
                    <a href="{{ route('stories.show', ['id' => 3]) }}">
                        <img src="{{ asset('images/story_water.jpg') }}" alt="">
                        <p>pri vode</p>
                    </a>
                </div>

                <div class="story">
                    <a href="{{ route('stories.show', ['id' => 4]) }}">
                        <img src="{{ asset('images/story_history.jpg') }}" alt="">
                        <p>história</p>
                    </a>
                </div>

                <div class="story">
                    <a href="{{ route('stories.show', ['id' => 5]) }}">
                        <img src="{{ asset('images/story_parkfive.jpg') }}" alt="">
                        <p>parkFIVE</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="section-1">
            <div class="text">
                <div class="fist-section"> 
                    <h1>Toto je dôvod, prečo prísť!</h1>
                    <p>Miesto, kde sa spája relax a zábava! Užite si krištáľovo čistú vodu, ktorá vás osvieži počas horúcich dní alebo horúcu saunu v chladnejšom počasí.</p>
                </div>

                <div class="second-section">
                    <h1>Súkromie na prvom mieste</h1>
                    <p>Do bazénu majú prístup len hostia aoartmánov. Žiadne bitie sa o lehátko a slnečník ani žiadne zvedavé pohľady.</p> 
                </div>  
                
            </div>
            <div class="layout">
                <svg id="eMbAp7FBxZ81" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1920 1080" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" project-id="47c0fa7cd2434aeaac1a939cd5e01861" export-id="7f992ff2418f4988abc18089148dbe16" cached="false">

                <rect width="1809.333125" height="523.14584" rx="0" ry="0" transform="translate(53.688213 522.630951)" fill="#b19d9c" stroke-width="0"/>
                <rect width="975.685261" height="398.751371" rx="0" ry="0" transform="translate(887.336078 62.397558)" fill="none" stroke="#b19d9c"/>
                <rect width="255.609852" height="368.078188" rx="50" ry="50" transform="translate(904.376734 79.438215)" fill="#b19d9c" stroke-width="0"/>
                <rect width="410.125504" height="268.977254" rx="50" ry="50" transform="translate(1177.047554 79.438215)" fill="#b19d9c" stroke-width="0"/>
                <rect width="240.889129" height="271.041857" rx="50" ry="50" transform="matrix(1 0 0 0.984765 1608.674769 80.470575)" fill="#b19d9c" stroke-width="0"/>
                <ellipse class="hover-target" rx="34.384853" ry="34.384853" transform="translate(703.01345 707.569766)" fill="#fff" stroke-width="0" data-heading="Bazén" data-description="Veľký vonkajší bazén, ideálny na relaxáciu a osvieženie počas slnečných dní. Možné plávanie s protiprúdom." data-images="images/wellness_pool.jpg,images/wellness_pool.jpg,images/wellness_pool.jpg"/>
                <ellipse class="hover-target" rx="34.384853" ry="34.384853" transform="matrix(.64115 0 0 0.64115 1729.119334 213.926843)" fill="#fff" stroke-width="0" data-heading="Ochladzovací bazén" data-description="Osviežujúci bazén určený na ochladenie po saunovaní, poskytujúci revitalizujúci zážitok." data-images="images/wellness_pool.jpg,images/wellness_pool.jpg,images/wellness_pool.jpg"/>
                <ellipse class="hover-target" rx="34.384853" ry="34.384853" transform="matrix(.64115 0 0 0.64115 1382.110306 213.926842)" fill="#fff" stroke-width="0" data-heading="Vírivka" data-description="Vírivka s prúdmi teplej vody, ktoré vám pomôžu dokonale zrelaxovať a uvoľniť sa." data-images="images/wellness_pool.jpg,images/wellness_pool.jpg,images/wellness_pool.jpg"/>
                <ellipse class="hover-target" rx="34.384853" ry="34.384853" transform="matrix(.64115 0 0 0.64115 1032.18166 213.926843)" fill="#fff" stroke-width="0" data-heading="Sauna" data-description="Tradičná sauna so suchým teplom a dreveným interiérom, ideálna na detoxikáciu a zmiernenie stresu." data-images="images/wellness_pool.jpg,images/wellness_pool.jpg,images/wellness_pool.jpg"/>
                </svg>
            </div>
            <div id="tooltip" class="tooltip">
                <h3 id="tooltip-heading" class="tooltip-heading"></h3>
                <p id="tooltip-description" class="tooltip-description"></p>
                <div id="tooltip-images" class="tooltip-images"></div>
            </div>
            
        </div>

        <div class="section-2" id="trips">
            <div class="column-1">
                <h1>Výlety akurát na víkend</h1>
                <p>Objavte malebné zákutia, historické pamiatky a prírodné scenérie, ktoré dokonale vyplnia váš víkendový program a zanechajú vo vás trvalé spomienky.</p>
                <iframe src="https://snazzymaps.com/embed/668211" width="100%" height="480px" style="border:none;border-radius: 50px;"></iframe>
                <a href="#">
                    aktivity a relax
                    <i class="bi bi-map"></i>
                </a>      
            </div>

            <div class="column-2">
                <div class="minisection">
                    <h1>Kam vyrazíte?</h1>
                    <p>Stiahnite si našich sprievodcov a objavte krásy okolitej krajiny plnej jedinečných zážitkov a inšpirácií.</p>
                </div>


                <div class="minisection">
                    <img src="{{ asset('images/trips_park.png') }}" alt="">     
                    <a href="#">
                        sprievodca prírodou
                        <i class="bi bi-cloud-download"></i>
                    </a> 
                </div>

                <div class="minisection">
                    <img src="{{ asset('images/trips_castle.png') }}" alt="">     
                    <a href="#">
                        sprievodca históriou
                        <i class="bi bi-cloud-download"></i>
                    </a> 
                </div>
                
            </div>
        </div>
    </div>
    @include('components.navbar')
    @include('components.booking')
    @include('components.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>

<script>
   document.addEventListener('DOMContentLoaded', () => {
    const tooltip = document.getElementById('tooltip');
    let hideTimeout;

    document.querySelectorAll('.hover-target').forEach(ellipse => {
        ellipse.addEventListener('mouseenter', (e) => {
            clearTimeout(hideTimeout); // Cancel any hide timeout
            const heading = e.target.getAttribute('data-heading');
            const description = e.target.getAttribute('data-description');
            const imageList = e.target.getAttribute('data-images').split(',');

            tooltip.querySelector('.tooltip-heading').textContent = heading;
            tooltip.querySelector('.tooltip-description').textContent = description;

            const imageContainer = tooltip.querySelector('.tooltip-images');
            if (imageContainer) {
                imageContainer.innerHTML = '';
                imageList.forEach(src => {
                    const img = document.createElement('img');
                    img.src = src;
                    img.alt = heading;
                    img.style.marginBottom = '8px';
                    imageContainer.appendChild(img);
                });
            }

            // Calculate position relative to the document
            const rect = e.target.getBoundingClientRect();
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

            // Position the tooltip to the left
            tooltip.style.left = `${rect.x - tooltip.offsetWidth + scrollLeft}px`;
            tooltip.style.top = `${rect.y + rect.height / 2 + scrollTop - tooltip.offsetHeight / 2}px`;
            tooltip.style.visibility = 'visible';
            tooltip.style.opacity = 1;
        });

        ellipse.addEventListener('mouseleave', () => {
            hideTimeout = setTimeout(() => {
                tooltip.style.visibility = 'hidden';
                tooltip.style.opacity = 0;
            }, 100); // Add a small delay
        });
    });

    tooltip.addEventListener('mouseenter', () => {
        clearTimeout(hideTimeout);
        tooltip.style.visibility = 'visible';
        tooltip.style.opacity = 1;
    });

    tooltip.addEventListener('mouseleave', () => {
        tooltip.style.visibility = 'hidden';
        tooltip.style.opacity = 0;
    });
});
</script>
</html>
