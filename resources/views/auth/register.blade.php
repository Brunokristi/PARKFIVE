<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrácia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Upozornenie</strong>
                            <small class="text-muted">práve teraz</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            {{ $error }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="col-md-4 bg-white p-4 rounded">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <h2 class="text-center mb-4">Registrácia</h2>
                    <div class="mb-3">
                        <label for="name" class="form-label">Meno</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Heslo</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Potvrdiť heslo</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrovať</button>
                </form>

                <div class="text-center mt-3">
                    <p class="fw-light">alebo</p>
                    <a href="{{ route('google.redirect') }}" class="btn btn-danger w-100">
                        Registrovať sa cez Google
                    </a>
                </div>
                <div class="text-center">
                    <p class="fw-light mt-3">
                        Máte už účet? <a href="{{ route('login') }}" class="text-primary">Prihláste sa</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toastElements = document.querySelectorAll('.toast');
            toastElements.forEach((toastEl) => {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        });
    </script>
</body>
</html>
