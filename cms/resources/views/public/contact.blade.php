@extends('public.layout')
@section('title', 'Contact Us | State Corps')
@section('content')
<main class="container py-5">
    <h1>Contact Us</h1>
    @if(session('success'))<p class="alert alert-success">{{ session('success') }}</p>@endif
    <form method="post" action="{{ route('contact.store') }}" class="row g-3" style="max-width: 720px">
        @csrf
        <div class="d-none"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="col-md-6"><label class="form-label" for="name">Name</label><input class="form-control" id="name" name="name" value="{{ old('name') }}" required>@error('name')<small class="text-danger">{{ $message }}</small>@enderror</div>
        <div class="col-md-6"><label class="form-label" for="email">Email</label><input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" required>@error('email')<small class="text-danger">{{ $message }}</small>@enderror</div>
        <div class="col-md-6"><label class="form-label" for="phone">Phone</label><input class="form-control" id="phone" name="phone" value="{{ old('phone') }}"></div>
        <div class="col-12"><label class="form-label" for="message">Message</label><textarea class="form-control" id="message" name="message" rows="7" required>{{ old('message') }}</textarea>@error('message')<small class="text-danger">{{ $message }}</small>@enderror</div>
        <div class="col-12"><button class="hero-btn" type="submit">Send Message</button></div>
    </form>
</main>
@endsection