<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard">parkFIVE admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" href="/rooms">Izby</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Rezervácie</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">Rezervácie Kalendár</h5>
            </div>
            <div class="card-body p-4">
                <iframe 
                    src="https://calendar.google.com/calendar/embed?height=600&wkst=2&ctz=Europe%2FPrague&showPrint=0&showTz=0&showTitle=0&src=ZThjMTRmNzNmZTYyNDE1ZTVhODMxZWM1NTJjZGJkNmE1NGYyNTIzMGMxNTVhNjIzZjhhZTc2MzJjMzRhNjI3Y0Bncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=ZmVhMDRmZGI3ZDUyMWZlOGQ5ZTMzYmI0YTEzNjU5YTZlMjdmZWYwZjlkNzI0Y2UxZGNhNWI1MTY1OWU5NmJkOEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=NGFvN2pmNHRoODVhNmRydGpmc2w4a25hZjc5aHZ1OW9AaW1wb3J0LmNhbGVuZGFyLmdvb2dsZS5jb20&src=NmxnbHY0MWVuZG05YXV0aTVzbGNubXNzOW43cDcyY3JAaW1wb3J0LmNhbGVuZGFyLmdvb2lsZS5jb20&color=%237CB342&color=%23F6BF26&color=%233F51B5&color=%23009688" 
                    class="w-100" 
                    height="600" 
                    frameborder="0" 
                    scrolling="no">
                </iframe>
            </div>
        </div>
    </div>


</html>
