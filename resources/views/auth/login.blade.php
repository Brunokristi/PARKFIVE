<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <div class="mx-auto flex min-h-screen max-w-md items-center px-6">
        <form method="post" action="/login" class="w-full rounded-2xl border border-white/10 bg-white/5 p-8 shadow-2xl">
            @csrf
            <h1 class="text-3xl font-semibold">Hotel admin</h1>
            <p class="mt-2 text-sm text-neutral-400">Sign in to manage the property content.</p>

            @if ($errors->any())
                <div class="mt-6 rounded-lg border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <label class="mt-6 grid gap-2">
                <span class="text-sm text-neutral-400">Email</span>
                <input name="email" type="email" value="{{ old('email') }}" class="rounded-lg border border-white/10 bg-neutral-950 px-4 py-3 text-white" required autofocus>
            </label>

            <label class="mt-4 grid gap-2">
                <span class="text-sm text-neutral-400">Password</span>
                <input name="password" type="password" class="rounded-lg border border-white/10 bg-neutral-950 px-4 py-3 text-white" required>
            </label>

            <label class="mt-4 flex items-center gap-2 text-sm text-neutral-400">
                <input type="checkbox" name="remember" class="rounded border-white/20 bg-neutral-950">
                Remember me
            </label>

            <button class="mt-6 w-full rounded-full bg-white px-5 py-3 font-semibold text-neutral-950" type="submit">Log in</button>
        </form>
    </div>
</body>
</html>