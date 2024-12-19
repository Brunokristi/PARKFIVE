<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            flex-wrap: nowrap;
            gap: 30px;
            margin: 50px auto;
            margin-bottom: 70px;
            overflow-x: auto;
            width: 100%;
            padding: 20px;
            scroll-behavior: smooth;
            background-color: #B89080;
            border-radius: 50px;
        }

        .reviews::-webkit-scrollbar {
            display: none;
        }

        .review-box {
            background-color: #fff;
            color: #B19D9C;
            border: 1px solid #B19D9C;
            border-radius: 50px;
            padding: 20px;
            text-align: center;
            width: 250px;
            height: 250px;
            flex: 0 0 auto;
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
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 10px;
            border: 1px solid #B19D9C;
        }

        .bar div {
            height: 100%;
            background-color: #B19D9C;
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
            color: #B89080;
        }

        .flag {
            width: 20px;
            height: 15px;
            border-radius: 2px;
        }

        

        /* rooms */

        .rooms {
            margin: 20px auto;
            font-family: 'Inter', sans-serif;
        }

        .rooms h1, h2 {
            font-size: 30px;
            margin-bottom: 20px;
            color: #B19D9C;
            font-family: 'Gotu', sans-serif;
            font-weight: 100;
        }

        .rooms h2 {
            font-size: 24px;
            color: #fff;
        }   

        .rooms hr {
            margin: 50px 0;
            color: #B89080;
        }

        .room-card {
            display: flex;
            justify-content: space-between;
            background-color: #fff; 
            border: 1px solid #B19D9C;
            border-radius: 50px;
            padding: 20px;
            margin-bottom: 30px;
            width: 100%;
        }

        .room-features {
            background-color: #B19D9C;
            color: #fff;
            border-radius: 50px;
            padding: 20px;
            width: 30%;
            text-align: center;
            height: 500px;
            overflow-y: auto;
        }

        .room-features hr {
            margin: 10px 0;
            color: #fff;
        }

        .rooms .btn {
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            background-color: #fff;
            color: #fff;
            background-color: #B19D9C;  
            width: 300px;
        }

        .rooms .btn:hover {
            background-color: #B89080;
        }

        .btn-primary:active, 
        .btn-primary:focus, 
        .btn-primary:active:focus {
            background-color: #B89080 !important;
        }

        .bed-item, .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .room-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            padding-bottom: 0;
        }

        .room-details h2 {
            color: #B19D9C; 
            margin-bottom: 15px;
        }

        .room-price {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 30px 0;
            padding: 5px 20px;
            border-radius: 50px;
            border: 1px solid #B19D9C;
            width: fit-content;
        }

        .room-price .price {
            font-size: 24px;
            color: #B19D9C;
        }

        .room-images {
            display: flex;
            gap: 10px;
            margin-top: auto;
            overflow-x: auto;
        }

        .room-images img {
            width: 300px;
            height: 200px;
            border-radius: 50px;
            object-fit: cover;
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

        .room-features::-webkit-scrollbar {
            display: none;
        }

        .group {
            border: solid 1px #fff;
            border-radius: 50px;
            padding: 20px;
            margin-top: 20px;
        }

    </style>
<body>
    <div class="main">
        <div class="booking">
            <h1>Rezervovať online</h1>
            <form action="{{ route('bookings.getRooms') }}" method="POST">
                @csrf
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

        <div class="rooms">
            @if (!isset($rooms))
                {{-- Do nothing when $rooms is not set --}}
            @elseif ($rooms->isEmpty())
                <h1 style="text-align: center;">Pre zadané dátumy nie sú voľné izby</h1>
            @else
                <hr>
                <h1 style="text-align: center;">Voľné izby</h1>
                @foreach ($rooms as $room)

                <div class="room-card">
                    <div class="room-features">
                        <h2>1 - {{ $room-> guests}} osôb</h2>

                        <div class="group">
                            <h2>Lôžka</h2>
                            @foreach ($room->beds as $bed)
                                <hr>
                                <p>{{ $bed->name }}: {{ $bed->count }}</p>
                            @endforeach
                        </div>

                        <div class="group">
                            <h2>Služby</h2>
                            @foreach ($room->features as $facility)
                                <hr>
                                <p>{{ $facility->name }}</p>
                            @endforeach
                        </div>
                    </div>

                    @php
                        $arrivalDate = \Carbon\Carbon::createFromFormat('Y-m-d', $arrival);
                        $departureDate = \Carbon\Carbon::createFromFormat('Y-m-d', $departure);
                        $nights = abs($departureDate->diffInDays($arrivalDate));

                        $pricePerNight = $room->price_per_night;
                        $totalCost = $nights * $pricePerNight;
                    @endphp

                    <!-- Room Details Column -->
                    <div class="room-details">
                        <h1>{{ $room->name }}</h1>
                        <h2 class="room-price">{{ $totalCost }}€ / {{ $nights }} nocí</h2>
                        <form action="{{ route('bookings.topay') }}" method="POST">
                            @csrf
                            <input type="hidden" name="room_name" value="{{ $room->name }}">    
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <input type="hidden" name="arrival" value="{{ $arrival }}">
                            <input type="hidden" name="departure" value="{{ $departure }}">
                            <input type="hidden" name="guests" value="{{ $guests }}">
                            <input type="hidden" name="total_cost" value="{{ $totalCost }}">
                            <button type="submit" class="btn btn-primary">Rezervovať a zaplatiť <i class="bi bi-chevron-right"></i></button>
                        </form>

                        <div class="dates">
                            <p>Počet osôb: {{ $guests }}</p>
                            <p>Príchod: {{ $arrival }}</p>
                            <p>Odchod: {{ $departure }}</p>
                        </div>

                        <div class="room-images">
                            @if ($room->images && $room->images->count() > 0)
                                @foreach ($room->images->where('type', 'image') as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Room Layout" class="thumbnail">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                <hr>
            @endif
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
                    <span>Rudolf</span>
                </div>
            </div>

            <div class="review-box comment">
                <p>
                    „Báječná lokalita vedle největšího parku ve městě, kde jsou dětská hřiště, krásné procházky a je to nedaleko centra. Byt je skvěle vybaven a pro …“
                </p>
                <div class="user">
                    <span>D</span>
                </div>
            </div>

            <div class="review-box comment">
                <p>
                    „Báječná lokalita vedle největšího parku ve městě, kde jsou dětská hřiště, krásné procházky a je to nedaleko centra. Byt je skvěle vybaven a pro …“
                </p>
                <div class="user">
                    <span>D</span>
                </div>
            </div>

            <div class="review-box comment">
                <p>
                    „Báječná lokalita vedle největšího parku ve městě, kde jsou dětská hřiště, krásné procházky a je to nedaleko centra. Byt je skvěle vybaven a pro …“
                </p>
                <div class="user">
                    <span>D</span>
                </div>
            </div>

            <div class="review-box comment">
                <p>
                    „Báječná lokalita vedle největšího parku ve městě, kde jsou dětská hřiště, krásné procházky a je to nedaleko centra. Byt je skvěle vybaven a pro …“
                </p>
                <div class="user">
                    <span>D</span>
                </div>
            </div>

            <div class="review-box comment">
                <p>
                    „Báječná lokalita vedle největšího parku ve městě, kde jsou dětská hřiště, krásné procházky a je to nedaleko centra. Byt je skvěle vybaven a pro …“
                </p>
                <div class="user">
                    <span>D</span>
                </div>
            </div>


            <div class="review-box comment">
                <p>
                    „Báječná lokalita vedle největšího parku ve městě, kde jsou dětská hřiště, krásné procházky a je to nedaleko centra. Byt je skvěle vybaven a pro …“
                </p>
                <div class="user">
                    <span>D</span>
                </div>
            </div>
        </section>
    </div>
    
    @include('components.navbar')
    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

        const reviewsContainer = document.querySelector(".reviews");

        reviewsContainer.addEventListener("wheel", (event) => {
            if (event.deltaY !== 0) { // Check if the wheel scrolls vertically
                event.preventDefault(); // Prevent default vertical scrolling
                reviewsContainer.scrollLeft += event.deltaY; // Scroll horizontally
            }
        });
    });
    </script>

</body>
</html>