<p><strong>Name:</strong> {{ $inquiry->name }}</p>
<p><strong>Email:</strong> {{ $inquiry->email }}</p>
@if($inquiry->phone)<p><strong>Phone:</strong> {{ $inquiry->phone }}</p>@endif
<p><strong>Message:</strong></p>
<p>{{ $inquiry->message }}</p>