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
        .booking {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            position: fixed;
            bottom: 0;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);

        }

        .booking h1 {
            color: #B19D9C;
            margin: 0;
            flex: 1;
            font-size: 25px;
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
            color: #B19D9C;
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
            background-color: #B19D9C;
            color: #fff;
        }

        .booking button:hover {
            background-color: #B89080;
            color: #fff;
        }
    </style>
<body>
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
                    Rezervovať
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </form>
    </div>
</body>
</html>