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
        .footer-bottom {
            display: flex;
            text-align: center;
            justify-content: center;
            padding-right: 95px;
            padding-bottom: 90px;
            padding-top: 20px;
            
        }

        .footer_container {
            background: linear-gradient(to bottom right, #B89080, #B19D9C);
            padding-top: 25px;
            padding-left: 50px;
        }


        @media screen and (max-width: 992px) {

            .footer_container {
                padding-left: 25px;
            }

            .footer-bottom {
                padding-right: 25px;
            }
        }

        @media screen and (max-width: 576px) {
            html {
                font-size: 14px;
            }

            body {
                font-size: 0.8rem;
            }

            .footer_container {
                padding-left: 20px;
            }

            .footer-bottom {
                padding-right: 20px;
            }
        }

        .footer_container h1 {
            font-family: 'Inter', sans-serif;
            font-size: 30px;
            font-weight: 300;
        }

        .footer_container a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            padding-bottom: 20px;
        }

        .footer_container p {
            color: #fff;
            font-size: 1rem;
        }

        .footer_container a:hover {
            color: #B89080;
        }

        .footer-link:hover {
            color: #B89080;
            cursor: pointer;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding-top: 80px;
        }

        .footer-column {
            display: flex;
            flex-direction: column;
        }

        .blur {
            filter: blur(5px);
            transition: filter 0.3s ease;
        }

        .shadowed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent background */
            z-index: 1000;
            /* Ensure it appears above other content */
        }

        @media screen and (max-width: 600px) {
            body {
                display: flex;
                flex-direction: column;
            }

            .map {
                width: 100%;
                order: 2;
            }

            .contact {
                width: 100%;
                order: 1;
                margin-bottom: 30px;
            }

            .btn {
                font-size: 14px;
            }

            .footer-grid a {
                font-size: 14px;
                height: 70px;
            }
        }
    </style>
</head>
<body>
    <div class="footer_container">
        <h1>ParkFIVE</h1>
        <p>Ubytovanie a Apartmány v Lučenci</p>


        <div class="footer-grid">
            <div class="footer-column">
                <a href="https://www.instagram.com/ermiss_hostess_agency/" target="_blank">Instagram</a>
                <a href="https://www.linkedin.com/company/105180196/admin/dashboard/" target="_blank">Linked In</a>
                <a href="contact.html">Kontakt</a>
            </div>
            <div class="footer-column">
                <a>Ermiss, s.r.o.</a>
                <a>K. Kuzmányho 3, Lučenec</a>
                <a>IČO: 56 016 255</a>
            </div>
            <div class="footer-column">
                <a href="https://drive.google.com/file/d/1d-FQCRgUfi3iisezCAXb2PZkfUMUCUFD/view?usp=drive_link" target="_blank">Ochrana osobných udajov</a>
                <a href="https://drive.google.com/file/d/1RG0ZMhgmPPABbYI-lVBxJnIjcOoETK_l/view?usp=drive_link" target="_blank">Nastavenia cookies</a>
                <a href="positions.html">Spolupráca</a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>2024 ermiss s.r.o.</p>
        </div>
    </div>
</body>
</html>