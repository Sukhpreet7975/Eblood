<nav>
<a href="/">Home</a>
@if(Auth::check())
<a href="{{ Auth::user()->isAdmin() ? '/admin/home' : (Auth::user()->isRequester() ? '/my-requests' : '/donor/home') }}">Dashboard</a>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
@else
<a href="/login">Login</a>
<a href="/register">Register</a>
@endif
</nav>