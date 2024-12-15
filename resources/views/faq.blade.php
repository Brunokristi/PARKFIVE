<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otázky a odpovede - ubytovanie v Lučenci</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            color: #B19D9C;
            font-weight: 300;
            font-size: 16px;
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

        .main h1 {
            font-size: 30px;
            margin-bottom: 20px;
            color: #B19D9C;
            font-family: 'Gotu', sans-serif;
            font-weight: 100;
        }

        p {
            font-size: 16px;
            margin-bottom: 20px;
            color: #B89080;
            font-family: 'Inter', sans-serif;
            font-weight: 300;
        }

        .faq {
            margin: 20px 0px;
            border: solid 1px #B89080;
            border-radius: 50px;
            padding: 10px;
        }

        .faq:first-child {
            margin-top: 50px;
        }

        .faq_question {
            display: inline-block;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Gotu', sans-serif;
            font-weight: 300;
            font-size: 20px;
            color: #B89080;
            margin: 10px 20px;
        }

        .faq_answer_container {
            padding-top: 10px;
            margin: 20px;
            display: none;
            border-top: 1px solid #B89080;
            color: #B19D9C; 
        }

        .faq_icon {
            font-size: 15px;
            color: #B89080;
        }

        .links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding: 20px;
            font-family: 'Gotu', sans-serif;
            font-weight: 300;
            font-size: 20px;
            background-color: #B89080;
            border-radius: 50px;
            color: #fff;
        }

        .btn_body {
            background-color: #fff;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            font-size: 17px;
            padding: 10px 20px;
            font-weight: 300;
            font-family: 'Inter', sans-serif;
            color: #B19D9C;
            text-decoration: none;
        }

        .btn_body:hover {
            transition: all 0.6s;
            padding: 12px 22px;
        }

        .btn_body i {
            margin-left: 20px;
        }


    </style>

</head>
<body>
    <div class="main">
        <h1>Radi odpovieme na Vaše otázky</h1>
        <div class="faq_container">
            <div class="faq">
                <div class="faq_question">
                    <div class="text">Aký je čas príchodu a odchodu (check-in a check-out)?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="faq_answer_container">
                    <div class="faq_answer">Check-in je možný od 15:00 a check-out je potrebné vykonať do 11:00. Ak potrebujete individuálny čas príchodu alebo odchodu, kontaktujte nás a pokúsime sa vám vyhovieť.</div>
                </div>
            </div>

            <div class="faq">
                <div class="faq_question">
                    <div class="text">Môžem prísť so zvieratami?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="faq_answer_container">
                    <div class="faq_answer">Žiaľ, domáci miláčikovia majú pobyt zakázaný.</div>
                </div>
            </div>

            <div class="faq">
                <div class="faq_question">
                    <div class="text">Má ubytovanie parkovacie miesto?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="faq_answer_container">
                    <div class="faq_answer">Áno, pre našich hostí je k dispozícii bezplatné parkovacie miesto priamo pri ubytovaní.</div>
                </div>
            </div>

            <div class="faq">
                <div class="faq_question">
                    <div class="text">Je v cene zahrnuté Wi-Fi?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="faq_answer_container">
                    <div class="faq_answer">Áno, vysokorýchlostné Wi-Fi pripojenie je zahrnuté v cene ubytovania.</div>
                </div>
            </div>

            <div class="faq">
                <div class="faq_question">
                    <div class="text">Aké sú možnosti zrušenia rezervácie?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="faq_answer_container">
                    <div class="faq_answer">Rezerváciu môžete zrušiť bez poplatku do 7 dní pred príchodom. Pri neskoršom zrušení sa účtuje poplatok vo výške 50 % z ceny ubytovania.</div>
                </div>
            </div>

            <div class="faq">
                <div class="faq_question">
                    <div class="text">Poskytujete uteráky a posteľnú bielizeň?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="faq_answer_container">
                    <div class="faq_answer">Áno, všetci hostia majú k dispozícii čisté uteráky a posteľnú bielizeň.</div>
                </div>
            </div>

            <div class="faq">
                <div class="faq_question">
                    <div class="text">Môžem si priniesť vlastné jedlo?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="faq_answer_container">
                    <div class="faq_answer">Samozrejme! Ubytovanie má plne vybavenú kuchyňu, kde si môžete pripraviť vlastné jedlá.</div>
                </div>
            </div>

            <div class="faq">
                <div class="faq_question">
                    <div class="text">Máte nejaké pravidlá pre nočný kľud?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="faq_answer_container">
                    <div class="faq_answer">Áno, prosíme hostí, aby rešpektovali nočný kľud medzi 22:00 a 6:00, aby sme zabezpečili pohodlie všetkých našich hostí a susedov.</div>
                </div>
            </div>

            <div class="faq">
                <div class="faq_question">
                    <div class="text">Aké atrakcie sú v okolí?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="faq_answer_container">
                    <div class="faq_answer">V blízkosti sa nachádza množstvo atrakcií, vrátane historického centra, turistických chodníkov a miestnych reštaurácií. V ubytovaní nájdete brožúru s odporúčaniami.</div>
                </div>
            </div>

            <div class="links">
                <div class="text">Máte viac otázok?</div>
                <div class="buttons">
                    <a href="mailto:apartmentsparkfive@gmail.com" class="btn_body"> Ozvite sa nám<i class="bi bi-chevron-right"></i></a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function () {

        $('.faq_question').click(function () {

            if ($(this).parent().is('.open')) {
                $(this).closest('.faq').find('.faq_answer_container').slideUp();
                $(this).closest('.faq').removeClass('open');
                $(this).find('.bi').removeClass('bi-chevron-up').addClass('bi-chevron-down');

            } else {
                $('.faq_answer_container').slideUp();
                $('.faq').removeClass('open');
                $(this).closest('.faq').find('.faq_answer_container').slideDown();
                $(this).closest('.faq').addClass('open');
                $('.bi').removeClass('bi-chevron-up').addClass('bi-chevron-down');
                $(this).find('.bi').removeClass('bi-chevron-down').addClass('bi-chevron-up');
            }
        });

        $(document).ready(function () {
            $("#navbar").load("html/navbar.html");
            $("#footer").load("html/footer.html");
        });
    });
    </script>
</body>
</html>