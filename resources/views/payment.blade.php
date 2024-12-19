<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Parkfive - ubytovanie v Lučenci</title>
    <script src="https://js.stripe.com/v3/"></script>
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

        .info {
            margin: 20px auto;
            font-family: 'Inter', sans-serif;
        }

        .info h1, h2 {
            font-size: 30px;
            margin-bottom: 20px;
            color: #B89080;
            font-family: 'Gotu', sans-serif;
            font-weight: 100;
        }

        .info h2 {
            font-size: 24px;
            color: #fff;
        }   

        .info-card {
            display: flex;
            justify-content: space-between;
            background-color: #fff; 
            border: 1px solid #B19D9C;
            border-radius: 50px;
            padding: 20px;
            margin-bottom: 30px;
            width: 100%;
        }

        .room-details {
            background-color: #B19D9C;
            color: #fff;
            border-radius: 50px;
            padding: 20px;
            width: 30%;
            height: 600px;
            overflow-y: auto;
        }

        .room-details h1 {
            color: #fff;
            padding: 20px  0;
        }

        .room-details h2 {
            color: #fff;
            padding: 15px 0;
        }

        .room-details hr {
            margin: 10px 0;
            color: #fff;
        }

        .info .btn {
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            background-color: #fff;
            color: #fff;
            background-color: #B89080;  
            width: 300px;
        }

        .info .btn:hover {
            background-color: #fff;
            color: #B89080;
        }

        .btn-primary:active, 
        .btn-primary:focus, 
        .btn-primary:active:focus {
            background-color: #fff !important;
        }

        .bed-item, .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .contact-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            padding-bottom: 0;
        }

        .contact-info h1 {
            color: #B89080; 
            margin: 20px 0;
        }

        .contact-info hr {
            margin: 30px 0;
            color: #B89080;
        }

        .dates {
            margin-top: 20px;
            display: flex;
            gap: 30px;
        }

        .dates p {
            margin: 5px 0;
            font-size: 14px;
            color: #B19D9C;
        }

        .room-details::-webkit-scrollbar {
            display: none;
        }

        .group {
            border: solid 1px #fff;
            border-radius: 50px;
            padding: 20px;
            margin-top: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #B19D9C;
            margin-bottom: 5px;
        }

        .form-group input {
            border: 1px solid #ccc;
            border-radius: 50px;
            padding: 10px;
            box-sizing: border-box;
            color: #B19D9C;
        }


    </style>
<body>
    <div class="main">
        <div class="info">
            <div class="info-card">
                <div class="room-details">
                    <h1> {{ $room_name }} </h1>
                    <hr>
                    <h2>Detaily rezervácie</h2>
                    <p>Počet osôb: {{ $guests }}</p>
                    <p>Príchod: {{ $arrival }}</p>
                    <p>Odchod: {{ $departure }}</p>
                    <hr>
                    @php
                        define('TAX_RATE', 0.23);
                        $tax = TAX_RATE * $total_cost;
                        $price = $total_cost - $tax;
                    @endphp
                    <h2>Cena</h2>
                    <p> Cena bez DPH: {{ $price }}€ </p>
                    <p> DPH: {{ $tax }}€ </p>    
                    <p> Celkom: {{ $total_cost }}€ </p>
                </div>

                <!-- Room Details Column -->
                <div class="contact-info">
                    <h1>Vaše údaje</h1>
                   <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <!-- Name and Surname in one row -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Meno</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                            <div class="form-group">
                                <label for="surname">Priezvisko</label>
                                <input type="text" class="form-control" id="surname" name="surname">
                            </div>
                        </div>

                        <hr>

                        <!-- Email and Phone in one row -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>

                            <div class="form-group">
                                <label for="phone">Telefónne číslo</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>

                        <hr>

                        <!-- Address, City, and ZIP in one row -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="address">Adresa</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>

                            <div class="form-group">
                                <label for="city">Mesto</label>
                                <input type="text" class="form-control" id="city" name="city">
                            </div>

                            <div class="form-group">
                                <label for="zip">PSČ</label>
                                <input type="text" class="form-control" id="zip" name="zip">
                            </div>
                        </div>  
                        <input type="hidden" name="room_id" value="{{ $room_id }}">
                        <input type="hidden" name="arrival" value="{{ $arrival }}">
                        <input type="hidden" name="departure" value="{{ $departure }}">
                        <input type="hidden" name="guests" value="{{ $guests }}">
                        <input type="hidden" name="total_cost" value="{{ $total_cost }}">

                        <button type="submit" class="btn btn-primary">Zaplatiť <i class="bi bi-chevron-right"></i></button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @include('components.navbar')
    @include('components.footer')

    <script>
    </script>

</body>
</html>