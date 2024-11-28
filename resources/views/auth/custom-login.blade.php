<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h1>Custom Login Page</h1>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <hr class="my-4">

        <div class="text-center">
            <a href="{{ route('google.redirect') }}" class="btn btn-danger">
                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" style="width: 20px; margin-right: 8px;">
                Login with Google
            </a>
        </div>
    </div>
</body>
</html>
