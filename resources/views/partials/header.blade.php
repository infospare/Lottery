<header class="shadow-md" style="background-color: #E9ECE6;">
    <nav class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                    <img src="{{ asset('images/logo.png') }}" alt="Infospare" >
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ url('/') }}" class="font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Home
                </a>
                <a href="{{ route('downloads') }}" class="font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Downloads
                </a>
                @auth
                <a href="{{ route('lottery.results') }}" class="font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Results
                </a>
                <a href="{{ route('lottery.results.manage') }}" class="font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Manage Results
                </a>
                <a href="{{ route('subscribers.index') }}" class="font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Subscribers
                </a>
                @endauth
                <a href="{{ route('about') }}" class="font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    About
                </a>
                <a href="{{ route('services') }}" class="font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Services
                </a>
                <a href="{{ route('contact') }}" class="font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Contact
                </a>
            </div>

            <!-- Auth Links / Mobile Menu -->
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('account') }}" class="btn btn-primary">
                        Account
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Login
                    </a>
                @endauth

                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden text-gray-700 dark:text-gray-300 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
            <a href="{{ url('/') }}" class="block py-2 font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                Home
            </a>
            <a href="{{ route('downloads') }}" class="block py-2 font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                Downloads
            </a>
            @auth
            <a href="{{ route('lottery.results') }}" class="block py-2 font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                Lottery Results
            </a>
            <a href="{{ route('lottery.results.manage') }}" class="block py-2 font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                Manage Results
            </a>
            <a href="{{ route('subscribers.index') }}" class="block py-2 font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                Subscribers
            </a>
            <a href="{{ route('account') }}" class="block py-2 font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                Account
            </a>
            @endauth
            <a href="{{ route('about') }}" class="block py-2 font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                About
            </a>
            <a href="{{ route('services') }}" class="block py-2 font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                Services
            </a>
            <a href="{{ route('contact') }}" class="block py-2 font-bold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                Contact
            </a>
        </div>
    </nav>
</header>

<script>
    document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
