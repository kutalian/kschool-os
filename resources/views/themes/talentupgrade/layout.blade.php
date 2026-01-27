<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        @yield('title', ($settings->school_name ?? $themeConfig['identity']['site_title'] ?? 'TalentUpgrade') . ' - ' . ($settings->tagline ?? $themeConfig['identity']['tagline'] ?? 'Best Kids Education'))
    </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="@yield('meta_description', $themeConfig['identity']['meta_description'] ?? '')">
    <meta name="keywords" content="@yield('meta_keywords', $themeConfig['identity']['meta_keywords'] ?? '')">

    <!-- Favicon -->
    <link href="{{ $settings->favicon_path ?? asset('favicon.ico') }}" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@200;300;400;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Vite/Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Theme Styles -->
    <style>
        :root {
            --primary-color:
                {{ $themeConfig['colors']['primary'] ?? '#17a2b8' }}
            ;
            --secondary-color:
                {{ $themeConfig['colors']['secondary'] ?? '#00394f' }}
            ;
            --accent-color:
                {{ $themeConfig['colors']['accent'] ?? '#ff6600' }}
            ;
            --bg-color:
                {{ $themeConfig['colors']['background'] ?? '#ffffff' }}
            ;
            --text-color:
                {{ $themeConfig['colors']['text'] ?? '#444444' }}
            ;
            --heading-font: '{{ $themeConfig['typography']['heading_font'] ?? 'Handlee' }}', cursive;
            --body-font: '{{ $themeConfig['typography']['body_font'] ?? 'Inter' }}', sans-serif;
        }

        .font-handlee {
            font-family: var(--heading-font);
        }

        .font-nunito {
            font-family: var(--body-font);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        .text-primary {
            color: var(--primary-color);
        }

        .bg-primary {
            background-color: var(--primary-color);
        }

        .text-secondary {
            color: var(--secondary-color);
        }

        .bg-secondary {
            background-color: var(--secondary-color);
        }

        .hero-header {
            background-color: var(--primary-color);
            margin-bottom: 90px;
            position: relative;
            padding: 3rem 0;
            color: white;
        }

        {!! $themeConfig['custom_css'] ?? '' !!}
    </style>
</head>

<body class="font-nunito">
    <!-- Navbar -->
    <div class="bg-secondary text-white py-2 px-6 flex justify-between items-center text-sm">
        <div>
            @if(isset($settings->social_links))
                @foreach($settings->social_links as $platform => $link)
                    <a class="text-white px-1 hover:text-primary transition" href="{{ $link }}">
                        <i class="fab fa-{{ $platform }}"></i>
                    </a>
                @endforeach
            @endif
        </div>
        <div>
            @auth
                <a href="{{ route('dashboard') }}" class="text-white hover:text-primary transition">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-white hover:text-primary transition px-2">Login</a>
            @endauth
        </div>
    </div>

    <nav class="bg-white shadow sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2 text-secondary font-bold text-3xl font-handlee">
                @if($settings->logo_path)
                    <img src="{{ $settings->logo_path }}" class="h-10" alt="Logo" loading="lazy">
                @elseif(isset($themeConfig['identity']['logo_url']) && $themeConfig['identity']['logo_url'])
                    <img src="{{ asset($themeConfig['identity']['logo_url']) }}" class="h-10" alt="Logo" loading="lazy">
                @else
                    <i class="fas fa-graduation-cap text-primary"></i>
                @endif
                {{ $settings->school_name ?? $themeConfig['identity']['site_title'] ?? 'TalentUpgrade' }}
            </a>

            <!-- Mobile Toggle -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-secondary focus:outline-none">
                <i class="fas fa-bars text-2xl" x-show="!mobileMenuOpen"></i>
                <i class="fas fa-times text-2xl" x-show="mobileMenuOpen" style="display: none;"></i>
            </button>

            <!-- Desktop Menu -->
            <div class="hidden md:flex gap-6 font-bold text-secondary">
                <a href="{{ route('home') }}"
                    class="hover:text-primary transition {{ request()->routeIs('home') ? 'text-primary' : '' }}">Home</a>
                <a href="{{ route('theme.page', 'about') }}"
                    class="hover:text-primary transition {{ request()->is('p/about') ? 'text-primary' : '' }}">About</a>
                <a href="{{ route('theme.page', 'classes') }}"
                    class="hover:text-primary transition {{ request()->is('p/classes') ? 'text-primary' : '' }}">Classes</a>
                <a href="{{ route('theme.page', 'teachers') }}"
                    class="hover:text-primary transition {{ request()->is('p/teachers') ? 'text-primary' : '' }}">Teachers</a>
                <a href="{{ route('theme.page', 'contact') }}"
                    class="hover:text-primary transition {{ request()->is('p/contact') ? 'text-primary' : '' }}">Contact</a>

                @if(isset($customPages) && $customPages->count() > 0)
                    <div class="relative group">
                        <button class="hover:text-primary transition flex items-center gap-1">
                            More <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl py-2 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all z-50">
                            @foreach($customPages as $cp)
                                <a href="{{ route('theme.page', $cp->slug) }}"
                                    class="block px-4 py-2 text-sm text-secondary hover:bg-blue-50 hover:text-primary">
                                    {{ $cp->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            class="md:hidden bg-white border-t border-gray-100 py-4 px-6 space-y-4 shadow-xl" style="display: none;">
            <a href="{{ route('home') }}"
                class="block font-bold text-secondary hover:text-primary {{ request()->routeIs('home') ? 'text-primary' : '' }}">Home</a>
            <a href="{{ route('theme.page', 'about') }}"
                class="block font-bold text-secondary hover:text-primary {{ request()->is('p/about') ? 'text-primary' : '' }}">About</a>
            <a href="{{ route('theme.page', 'classes') }}"
                class="block font-bold text-secondary hover:text-primary {{ request()->is('p/classes') ? 'text-primary' : '' }}">Classes</a>
            <a href="{{ route('theme.page', 'teachers') }}"
                class="block font-bold text-secondary hover:text-primary {{ request()->is('p/teachers') ? 'text-primary' : '' }}">Teachers</a>
            <a href="{{ route('theme.page', 'contact') }}"
                class="block font-bold text-secondary hover:text-primary {{ request()->is('p/contact') ? 'text-primary' : '' }}">Contact</a>

            @if(isset($customPages) && $customPages->count() > 0)
                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-2">More Pages</p>
                    @foreach($customPages as $cp)
                        <a href="{{ route('theme.page', $cp->slug) }}" class="block py-2 text-secondary hover:text-primary">
                            {{ $cp->title }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <div class="bg-secondary text-white mt-12 py-12">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <a href="/" class="flex items-center gap-2 text-white font-bold text-3xl font-handlee mb-4">
                    <i class="fas fa-child text-primary"></i> {{ $settings->school_name ?? $themeConfig['identity']['site_title'] ?? 'TalentUpgrade' }}
                </a>
                <p class="text-gray-300 text-sm">
                    Labore dolor amet ipsum ea, erat sit amet dolores autem, ipsum rebum stet amet sed eos condim.
                </p>
            </div>
            <div>
                <h3 class="text-primary font-bold text-lg mb-4 font-handlee">Get In Touch</h3>
                <div class="flex items-start gap-3 mb-2">
                    <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                    <p class="text-gray-300">{{ $settings->school_address ?? '123 Street' }}</p>
                </div>
                <div class="flex items-start gap-3 mb-2">
                    <i class="fas fa-envelope text-primary mt-1"></i>
                    <p class="text-gray-300">{{ $settings->school_email ?? 'info@example.com' }}</p>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-phone-alt text-primary mt-1"></i>
                    <p class="text-gray-300">{{ $settings->school_phone ?? '+012 345 6789' }}</p>
                </div>
            </div>
            <div>
                <h3 class="text-primary font-bold text-lg mb-4 font-handlee">Quick Links</h3>
                <div class="flex flex-col gap-2">
                    <a href="#" class="text-gray-300 hover:text-white"><i class="fas fa-angle-right mr-2"></i>Home</a>
                    <a href="#" class="text-gray-300 hover:text-white"><i class="fas fa-angle-right mr-2"></i>About
                        Us</a>
                    <a href="#" class="text-gray-300 hover:text-white"><i class="fas fa-angle-right mr-2"></i>Our
                        Classes</a>
                    <a href="#" class="text-gray-300 hover:text-white"><i class="fas fa-angle-right mr-2"></i>Contact
                        Us</a>
                </div>
            </div>
            <div>
                <h3 class="text-primary font-bold text-lg mb-4 font-handlee">Newsletter</h3>
                <form action="#" class="flex flex-col gap-3">
                    <input type="text" placeholder="Your Name"
                        class="p-2 rounded bg-white text-gray-800 border-none outline-none">
                    <input type="email" placeholder="Your Email"
                        class="p-2 rounded bg-white text-gray-800 border-none outline-none">
                    <button
                        class="bg-primary text-white py-2 rounded font-bold hover:bg-white hover:text-primary transition">Submit
                        Now</button>
                </form>
            </div>
        </div>
        <div class="container mx-auto px-6 mt-8 pt-8 border-t border-gray-700 text-center text-gray-400 text-sm">
            {!! nl2br(e($themeConfig['footer']['footer_text'] ?? "© 2026 " . ($settings->school_name ?? 'TalentUpgrade') . ". All Rights Reserved.")) !!}
        </div>
    </div>
</body>

</html>