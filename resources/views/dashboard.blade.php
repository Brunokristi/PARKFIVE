<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <div class="mx-auto flex min-h-screen max-w-4xl items-center px-6 py-16">
        <div class="w-full rounded-2xl border border-white/10 bg-white/5 p-8">
            <div class="text-xs uppercase tracking-[0.3em] text-neutral-400">parkFIVE</div>
            <h1 class="mt-3 text-4xl font-semibold">Dashboard</h1>
            <p class="mt-3 max-w-2xl text-neutral-400">
                Welcome, {{ auth()->user()->name }}.
                @if (auth()->user()->isAdmin())
                    You can manage the hotel from the admin backend.
                @else
                    You are signed in, but do not have admin access.
                @endif
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                @if (auth()->user()->isAdmin())
                    <a href="/admin" class="rounded-full bg-white px-5 py-2 text-sm font-semibold text-neutral-950">Open admin backend</a>
                @endif
                <form method="post" action="/logout">
                    @csrf
                    <button class="rounded-full border border-white/10 px-5 py-2 text-sm text-white hover:bg-white/10" type="submit">Log out</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>