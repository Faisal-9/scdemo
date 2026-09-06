<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Dashboard | State Corps</title></head>
<body>
    <header>
        <strong>State Corps Admin</strong>
        <span>{{ auth()->user()->name }} ({{ str_replace('_', ' ', auth()->user()->role) }})</span>
        <form method="post" action="{{ route('logout') }}">@csrf<button type="submit">Sign out</button></form>
    </header>
    <main>
        <h1>Dashboard</h1>
        <section><h2>{{ $drafts }}</h2><p>Draft content items</p></section>
        <section><h2>{{ $reviewItems }}</h2><p>Items awaiting review</p></section>
        <section><h2>{{ $newInquiries }}</h2><p>New contact inquiries</p></section>
    </main>
</body>
</html>
