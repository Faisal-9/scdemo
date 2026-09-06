<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Admin sign in | State Corps</title></head>
<body>
    <main>
        <h1>State Corps Admin</h1>
        <form method="post" action="{{ route('login') }}">
            @csrf
            <label>Email <input name="email" type="email" value="{{ old('email') }}" required autofocus></label>
            @error('email')<p>{{ $message }}</p>@enderror
            <label>Password <input name="password" type="password" required></label>
            <label><input name="remember" type="checkbox" value="1"> Remember me</label>
            <button type="submit">Sign in</button>
        </form>
    </main>
</body>
</html>
