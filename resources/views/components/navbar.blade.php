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
            color: #333;
            font-weight: 300;
            font-size: 16px;
            background-color: #fff;
        }

        .topnav h1 {
            font-family: 'Gotu', sans-serif;
            margin: 0;
            font-size: 25px;
            color: #B19D9C;
            z-index: 10000;
        }

        .topnav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            background-color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .topnav a {
            text-decoration: none;
            display: flex;
            align-items: center;

        }

        .topnav .logo img {
            height: 50px;
        }

        .nav-links a {
            text-decoration: none;
            color: #B19D9C;
            margin-left: 15px;
            font-size: 14px;
            display: inline-block;
            transition: color 0.3s;
            padding: 10px;
            border: 1px solid #B19D9C;
            border-radius: 50px;
        }

        .nav-links a:hover {
            color: #fff;
            background-color: #B19D9C;
        }

        .nav-links .icon {
            background-color: #B19D9C;
            color: #fff;
        }

        .nav-links_mobile {
            display: none;
            background-color: #B19D9C;
            justify-content: space-around;
            position: fixed;
            top: 70px;
            left: 0;
            width: 100%;
            padding: 20px;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.6s;
        }

        .nav-links_mobile.show {
            display: flex;
        }

        .nav-links_mobile a {
            color: #fff;
            padding: 10px 0;
            text-decoration: none;
            font-size: 14px;
        }

        .nav-links_mobile a:hover {
            transform: scale(1.1);
        }

    </style>

    </head>
    <body>
        <div class="topnav">
            <a href="/" class="logo">
                <img src="{{ asset('images/logo/parkfive_green_grey_logo.svg') }}" alt="Parkfive logo" class="logo">
                <h1>ParkFIVE</h1>
            </a>

            <div class="nav-links" id="desktop_menu">
                <a href="tel:+421911454678">Zavolajte nám</a>
                <a href="mailto:apartmentsparkfive@gmail.com">Napíšte nám</a>
                <a href="/bookings">Rezervovať </a>
                <a href="javascript:void(0);" class="icon" id="menu_icon"><i class="bi bi-list"></i></a>
            </div>
        
        </div>

        <div class="nav-links_mobile" id="mobile_menu">
            <a href="apartments" class="active">Izby a apartmány</a>
            <a href="/#trips">Aktivity a relax</a>
            <a href="wellness">Wellness</a>
            <a href="faq">Otázky a odpovede</a>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    </body>

    <script>
        const mobileMenu = document.getElementById("mobile_menu");
        const menuIcon = document.getElementById("menu_icon");

        // Show the menu on hover over the menu icon
        menuIcon.addEventListener("mouseenter", () => {
            mobileMenu.classList.add("show");
        });

        // Hide the menu when the mouse leaves the menu or icon
        mobileMenu.addEventListener("mouseleave", () => {
            mobileMenu.classList.remove("show");
        });

        menuIcon.addEventListener("mouseleave", () => {
            setTimeout(() => {
                if (!mobileMenu.matches(":hover")) {
                    mobileMenu.classList.remove("show");
                }
            }, 100); // Add a short delay to allow for smooth transitions
        });
    </script>

</html>
