<nav class="bg-white/95 border-b border-slate-200/70 backdrop-blur-xl shadow-sm dark:bg-slate-950/95 dark:border-slate-700/70">
    <div class="container mx-auto flex flex-wrap items-center justify-between gap-3 px-4 py-4">
        <a href="/" class="flex items-center gap-3 font-semibold text-slate-900 dark:text-white">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-red-600 text-white shadow-lg">E</span>
            <div class="leading-tight">
                <span class="block text-lg">E-Blood</span>
                <span class="block text-xs text-slate-500 dark:text-slate-400">Emergency support</span>
            </div>
        </a>

        <div class="flex flex-wrap items-center gap-3 text-sm">
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.home') }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                @else
                    <a href="/" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                @endif
            @else
                <a href="/" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
            @endauth
            <a href="/search" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Search Donors</a>

            @auth
                <a href="{{ Auth::user()->isAdmin() ? url('/admin') : (Auth::user()->isRequester() ? route('requester.home') : route('donor.home')) }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="rounded-full px-4 py-2 bg-red-600 text-white hover:bg-red-700">Logout</button>
                </form>
            @else
                <a href="/login" class="rounded-full px-4 py-2 bg-red-600 text-white hover:bg-red-700">Login</a>
                <a href="/register" class="rounded-full px-4 py-2 border border-slate-300 text-slate-700 hover:border-red-500 hover:text-red-600 dark:border-slate-700 dark:text-slate-200">Register</a>
            @endauth
        </div>
    </div>
</nav>