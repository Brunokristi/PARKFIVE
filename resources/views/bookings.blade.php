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
            justify-content: center;
            min-height: 100vh;
            background-color: #fff;
        }

        .main {
            width: 100%;
            padding: 20px;
            padding-top: 90px;
        }

        .booking {
            display: flex;
            align-items: center;
            justify-content: space-between; 
            flex-wrap: wrap;
            gap: 20px;
            background-color: #B89080;
            padding: 20px;
            border-radius: 50px;
        }

        .booking h1 {
            color: #fff;
            margin: 0;
            flex: 1;
            font-size: 25px;
            font-family: 'Gotu'
        }

        .booking form {
            display: flex;
            justify-content: flex-end; 
            padding: 0 20px;
            flex: 0 0 auto;
        }

        .booking .custom-input {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .booking input {
            text-decoration: none;
            font-size: 16px;
            background-color: #fff;
            color: #B19D9C;
            padding: 10px 20px;
            border-radius: 50px;
            margin: 0 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #B19D9C;
        }

        .booking input:focus {
            border: 1px solid #B89080;
            outline: none;
            color: #B19D9C;
        }

        .booking label {
            color: #fff;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        .booking input::placeholder {
            color: #B19D9C;
        }

        .booking a i{
            font-size: 20px;
            color: #B19D9C;
        }

        .booking button{
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            background-color: #fff;
            color: #B19D9C;
        }

        .booking button:hover {
            background-color: #B89080;
            color: #fff;
        }

        .reviews {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin: 50px auto;
            max-width: 1200px;
        }

        .review-box {
            background-color: #fff;
            color: #B19D9C;
            border: 1px solid #B19D9C;
            border-radius: 50px;
            padding: 20px;
            text-align: center;
            flex: 1;
            min-width: 200px;
            max-width: 250px;
        }

        .review-box.rating h1 {
            font-size: 3rem;
            margin: 10px 0;
        }

        .review-box.scores p {
            display: flex;
            justify-content: space-between;
            margin: 10px 0 5px;
            font-size: 0.9rem;
        }

        .bar {
            width: 100%;
            height: 5px;
            background-color: #B19D9C;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .bar div {
            height: 100%;
            background-color: #;
        }

        .review-box.comment p {
            font-size: 0.9rem;
            line-height: 1.5;
            color: #B19D9C;
        }

        .user {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
            gap: 10px;
        }

        .flag {
            width: 20px;
            height: 15px;
            border-radius: 2px;
        }
    </style>
<body>
    <div class="main">
        <div class="booking">
            <h1>Rezervovať online</h1>
            <form action="/submit-reservation" method="POST">
                    <!-- Príchod -->
                    <div class="col-auto custom-input">
                    <label for="arrival" class="form-label">Príchod</label>
                    <div class="input-group">
                        <input type="date" class="form-control" id="arrival" name="arrival" required>
                    </div>
                    </div>

                    <!-- Odchod -->
                    <div class="col-auto custom-input">
                    <label for="departure" class="form-label">Odchod</label>
                    <div class="input-group">
                        <input type="date" class="form-control" id="departure" name="departure" placeholder="oochod" required>
                    </div>
                    </div>

                    <!-- Počet osôb -->
                    <div class="col-2 custom-input">
                    <label for="guests" class="form-label">Hostia</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="guests" name="guests" min="1" placeholder="Počet" required>
                    </div>
                    </div>

                    <!-- Rezervovať -->
                    <div class="col-auto">
                    <button type="submit" class="btn btn-primary w-100">
                        Hľadať
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </form>
        </div>

        <section class="reviews">
            <div class="review-box rating">
                <p>hodnotenie</p>
                <h1>8.9</h1>
                <p>Vynikajúce</p>
                <p>Booking.com</p>
            </div>

            <div class="review-box scores">
                <p>wifi zdarma <span>10/10</span></p>
                <div class="bar"><div style="width: 100%;"></div></div>

                <p>čistota <span>9.7/10</span></p>
                <div class="bar"><div style="width: 97%;"></div></div>

                <p>pohodlie <span>9.2/10</span></p>
                <div class="bar"><div style="width: 92%;"></div></div>

                <p>kvalita/cena <span>9.1/10</span></p>
                <div class="bar"><div style="width: 91%;"></div></div>
            </div>

            <div class="review-box comment">
                <p>
                    „Všetko bolo krásne čisté a nové, keďže sme boli rodina s dvomi malými deťmi, tak sme si tam aj varili. V kuchyni nechýbalo žiadne kuchynské potreby.“
                </p>
                <div class="user">
                    <img src="images/sk_flag.png" alt="SK" class="flag">
                    <span>Rudolf</span>
                </div>
            </div>

            <div class="review-box comment">
                <p>
                    „Báječná lokalita vedle největšího parku ve městě, kde jsou dětská hřiště, krásné procházky a je to nedaleko centra. Byt je skvěle vybaven a pro …“
                </p>
                <div class="user">
                    <img src="images/cz_flag.png" alt="CZ" class="flag">
                    <span>D</span>
                </div>
            </div>
        </section>

    </div>
    
    @include('components.navbar')
    @include('components.footer')



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('/fetch-reserved-dates')
                .then(response => response.json())
                .then(reservedDates => {

                    console.log(reservedDates);
                    const arrivalInput = document.getElementById('arrival');
                    const departureInput = document.getElementById('departure');

                    const disableDates = (input) => {
                        input.addEventListener('input', function () {
                            if (reservedDates.includes(this.value)) {
                                alert('This date is already reserved!');
                                this.value = '';
                            }
                        });
                    };

                    disableDates(arrivalInput);
                    disableDates(departureInput);
                })
                .catch(error => console.error('Error fetching reserved dates:', error));
        });
    </script>

</body>
</html>