<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>@yield('title', 'Admin') | State Corps</title></head>
<body>
<header><a href="{{ route('admin.dashboard') }}">State Corps Admin</a> | <a href="{{ route('admin.projects.index') }}">Projects</a>
<form method="post" action="{{ route('logout') }}" style="display:inline">@csrf <button>Sign out</button></form></header>
@if(session('success'))<p>{{ session('success') }}</p>@endif
<main>@yield('content')</main>
</body></html>
