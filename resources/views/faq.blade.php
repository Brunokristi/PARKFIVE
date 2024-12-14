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
            color: #B89080;
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

        h1 {
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
            padding: 3px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            font-size: 17px;
            padding: 10px 20px;
            color: #000;
            font-weight: 300;
            font-family: 'Inter', sans-serif;
        }

        .btn_body:hover {
            background-color: #F2F0E4;
            color: #000;
        }
    </style>

</head>
<body>
    <div class="main">
        <h1>Radi odpovieme na Vaše otázky</h1>
        <div class="faq_container">
            <div class="faq">
                <div class="faq_question">
                    <div class="text">Ako zarezervovať hostesky a promotérov?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-up"></i>
                    </div>
                </div>
                <div class="faq_answer_container" style="display: block;">
                    <div class="faq_answer">Oboznámte nás s Vašim podujatím/akciou prostredníctvom emailu, telefonátu alebo vyplnením formuláru na našej stránke
                    Kontakt. Budeme Vás obratom kontaktovať s ponukou. Pre urýchlenie procesu prosím zadajte dôležité údaje ako čas, miesto
                    konania, priebeh akcie/eventu/...,počet požadovaných hostesiek/promotérov, Vaše kontaktné údaje a prípadne ďalšie
                    dôležité fakty. Vybať si môžete z nášho širokého portfólia hostesiek/promotérov, ktoré Vám ušijeme na mieru.
                    </div>
                </div>
            </div>

            <div class="faq">
                <div class="faq_question">
                    <div class="text">Zabezpečuje Ermiss uniformy/kostýmy pre hostestky a promotérov?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="faq_answer_container">
                    <div class="faq_answer">ÁNO, naša agentúra Vám rada pômože s výberom vhodného kostýmu/uniformiem podľa Vašich požiadaviek a charakteru
                    podujatia. Oblečenie je možné prenajať alebo zakúpiť. Obráťte sa na nás s Vašou predstavou ešte dnes.</div>
                </div>
            </div>

            <div class="faq">
                <div class="faq_question">
                    <div class="text">V akom časovom predstihu je potrebné si zarezervovať službu?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="faq_answer_container">
                    <div class="faq_answer">Aj keď by sme Vám najradšej všetko zorganizovali za jeden deň, niekedy to vyžaduje viac časovej dotácie aby bolo všetko
                    podľa Vášho plánu. Preto nás prosím kontaktuje aspoň v predstihu 7 dní pred konaním akcie. Pri akciách, ktoré si
                    vyžadujú väčší počet personálu, alebo máte špecifické preferencie ohľadom výberu hostesiek - kontaktujte nás minimálne
                    14 dní pred. Stále platí pravidlo, čím skôr tým lepšie.</div>
                </div>
            </div>

            <div class="faq">
                <div class="faq_question">
                    <div class="text">Aké sú podmienky zrušenia rezervácie personálu pred konaním akcie?</div>
                    <div class="faq_icon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="faq_answer_container">
                    <div class="faq_answer">Stáva sa to málokrát ale veríme, že sa môže naskytnúť výnimočná situácia a my sme ochotní Vám výjsť v ústrety. Náš
                    personál je vždy plne dedikovaný Vášmu eventu a je naň predom rezervovaný, prosíme Vás o oznámenie akýchkoľvek zmien
                    minimálne o 7 dní pred dohodnutým termínom akcie.</div>
                </div>
            </div>

            <div class="links">
                <div class="text">Máte viac otázok?</div>
                <div class="buttons">
                    <button onclick="showPopup()" class="btn_body"> Ozvite sa nám<i class="bi bi-chevron-right"></i></button>
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