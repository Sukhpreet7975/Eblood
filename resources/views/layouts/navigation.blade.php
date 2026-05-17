<nav>
<a href="/">Home</a>
@if(Auth::check())
<a href="/dashboard">Dashboard</a>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
@else
<a href="/login">Login</a>
<a href="/register">Register</a>
@endif
</nav>