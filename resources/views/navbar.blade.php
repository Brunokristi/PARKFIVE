<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"><link rel="stylesheet" type="text/css" href="../css/navbar.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;300;200&display=swap">
    </head>
    <body>

        <div class="topnav">
            <a href="#home" class="a_logo">
                <img src="../resources/images/logo_navbar.png" alt="Ermiss logo" class="logo">
            </a>
            <div class="nav-links" id="desktop_menu">
                <a href="index.html" class="active">Domov</a>
                <a href="services.html">Služby</a>
                <a href="about.html">O nás</a>
                <a href="faq.html">Q&A</a>
                <a href="gallery.html">Galéria</a>
                <a href="blog.html">Blog</a>
                <a href="positions.html">Spolupráca</a>
                <a href="contact.html">Kontakt</a>
                <button class="btn" onclick="showPopup()">Objednať <i class="fa fa-arrow-right"></i></button>
            </div>

            <div class="popup" id="popup">
                <h3>Sme tu pre Vás</h3>
                <p>Ako by ste chceli pokračovať?</p>
                <button class="option-btn" onclick="useEmail()">Email</button>
                <button class="option-btn" onclick="useWhatsApp()">WhatsApp</button>
                <button class="option-btn" onclick="makeCall()">Zavolať</button>
                <button class="close-btn" onclick="closePopup()">Zavrieť</button>
            </div>
            
            <div class="overlay" id="overlay" onclick="closePopup()"></div>
            
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i id ="hamburger" class="fa fa-bars"></i>
            </a>
        </div>

        <div class="nav-links_mobile" id="mobile_menu">
            <a href="index.html" class="active">Domov</a>
            <a href="services.html">Služby</a>
            <a href="about.html">O nás</a>
            <a href="faq.html">Q&A</a>
            <a href="gallery.html">Galéria</a>
            <a href="blog.html">Blog</a>
            <a href="positions.html">Spolupráca</a>
            <a href="contact.html">Kontakt</a>
            <a><button class="btn" onclick="showPopup()">Objednať <i class="fa fa-arrow-right"></i></button></a>
        </div>
    

    </body>

    <script>
        function myFunction() {
        var mobile = document.getElementById("mobile_menu");
        var icon = document.getElementById("hamburger");

        if (mobile.classList.contains("show")) {
            mobile.classList.remove("show");
            icon.classList.remove("fa-times");
            icon.classList.add("fa-bars");
        } else {
            mobile.classList.add("show");
            icon.classList.remove("fa-bars");
            icon.classList.add("fa-times");
        }
        }

        function showPopup() {
        document.getElementById("popup").style.display = "block";
        document.getElementById("overlay").style.display = "block";
        }

        function closePopup() {
        document.getElementById("popup").style.display = "none";
        document.getElementById("overlay").style.display = "none";
        }

        function useEmail() {
        window.location.href = "contact.html";
        closePopup(); // Close the popup
        }

        function useWhatsApp() {
        window.location.href = "https://wa.me/message/6SRLOWZO5K2YO1"; 
        closePopup(); // Close the popup
        }

        function makeCall() {
        window.location.href = "tel:+421 944 673 607"; // Change this to your phone number
        closePopup(); // Close the popup
        }
    </script>
</html>
