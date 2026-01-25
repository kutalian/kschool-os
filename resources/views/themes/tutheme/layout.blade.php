<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <title>{{ $settings->school_name ?? 'TalentUpgrade' }} - Nurturing Young Minds</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Quality education for children from Pre-K to Secondary School. Expert teachers, modern facilities, and a nurturing environment.">

    <!-- Favicon -->
    <link href="{{ $settings->favicon_path ?? asset('favicon.ico') }}" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Vite/Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: #17a2b8;
            --color-secondary: #00394f;
            --color-accent: #ffc107;
        }

        .font-handlee {
            font-family: 'Handlee', cursive;
        }

        .font-nunito {
            font-family: 'Nunito', sans-serif;
        }

        .text-primary {
            color: var(--color-primary);
        }

        .bg-primary {
            background-color: var(--color-primary);
        }

        .text-secondary {
            color: var(--color-secondary);
        }

        .bg-secondary {
            background-color: var(--color-secondary);
        }

        /* Animations */
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-left {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fade-in-right {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out;
        }

        .animate-fade-in-left {
            animation: fade-in-left 0.6s ease-out;
        }

        .animate-fade-in-right {
            animation: fade-in-right 0.6s ease-out;
        }

        .animate-bounce-slow {
            animation: bounce 3s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Mobile Menu */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .mobile-menu.active {
            max-height: 500px;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="font-nunito antialiased">
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-secondary to-blue-900 text-white py-3 px-6">
        <div class="container mx-auto flex flex-col sm:flex-row justify-between items-center text-sm gap-2">
            <div class="flex items-center gap-4">
                <a href="mailto:{{ $settings->school_email ?? 'info@example.com' }}" class="flex items-center gap-2 hover:text-primary transition">
                    <i class="fas fa-envelope"></i>
                    <span class="hidden sm:inline">{{ $settings->school_email ?? 'info@example.com' }}</span>
                </a>
                <a href="tel:{{ $settings->school_phone ?? '+234 123 456 7890' }}" class="flex items-center gap-2 hover:text-primary transition">
                    <i class="fas fa-phone"></i>
                    <span class="hidden sm:inline">{{ $settings->school_phone ?? '+234 123 456 7890' }}</span>
                </a>
            </div>
            <div class="flex items-center gap-4">
                @if(isset($settings->social_links) && is_array($settings->social_links))
                    @foreach($settings->social_links as $platform => $link)
                        <a class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-primary hover:scale-110 transition-all duration-300" 
                           href="{{ $link }}" 
                           aria-label="{{ ucfirst($platform) }}">
                            <i class="fab fa-{{ $platform }}"></i>
                        </a>
                    @endforeach
                @endif
                @auth
                    <a href="{{ route('dashboard') }}" class="ml-4 px-4 py-1 bg-primary rounded-full hover:bg-white hover:text-primary transition font-bold">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="ml-4 px-4 py-1 bg-white/10 rounded-full hover:bg-white hover:text-secondary transition font-bold">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50 backdrop-blur-sm bg-white/95">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 text-secondary font-bold text-2xl md:text-3xl font-handlee group">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center group-hover:rotate-6 transition-transform duration-300">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <span class="group-hover:text-primary transition-colors">
                        {{ $settings->school_name ?? 'TalentUpgrade' }}
                    </span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex gap-8 font-bold text-secondary items-center">
                    <a href="#" class="relative group py-2">
                        <span class="group-hover:text-primary transition-colors">Home</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#about" class="relative group py-2">
                        <span class="group-hover:text-primary transition-colors">About</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#classes" class="relative group py-2">
                        <span class="group-hover:text-primary transition-colors">Classes</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#teachers" class="relative group py-2">
                        <span class="group-hover:text-primary transition-colors">Teachers</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#gallery" class="relative group py-2">
                        <span class="group-hover:text-primary transition-colors">Gallery</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#contact" class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-full hover:shadow-xl hover:scale-105 transition-all duration-300">
                        Contact Us
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="lg:hidden w-10 h-10 flex items-center justify-center text-secondary hover:text-primary transition-colors" 
                        onclick="toggleMobileMenu()" 
                        aria-label="Toggle menu">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="mobile-menu lg:hidden">
                <div class="pt-4 pb-2 space-y-2">
                    <a href="#" class="block py-3 px-4 hover:bg-primary/10 hover:text-primary rounded-lg transition font-bold">Home</a>
                    <a href="#about" class="block py-3 px-4 hover:bg-primary/10 hover:text-primary rounded-lg transition font-bold">About</a>
                    <a href="#classes" class="block py-3 px-4 hover:bg-primary/10 hover:text-primary rounded-lg transition font-bold">Classes</a>
                    <a href="#teachers" class="block py-3 px-4 hover:bg-primary/10 hover:text-primary rounded-lg transition font-bold">Teachers</a>
                    <a href="#gallery" class="block py-3 px-4 hover:bg-primary/10 hover:text-primary rounded-lg transition font-bold">Gallery</a>
                    <a href="#contact" class="block py-3 px-4 bg-gradient-to-r from-primary to-secondary text-white rounded-lg hover:shadow-lg transition font-bold text-center">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Contact Section -->
    <section id="contact" class="bg-gray-50 py-24">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-block bg-primary/10 px-6 py-2 rounded-full mb-4">
                    <p class="text-primary font-bold font-handlee text-xl">📞 Get In Touch</p>
                </div>
                <h2 class="text-5xl md:text-6xl font-bold text-secondary font-handlee mb-4">Contact Us</h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">
                    Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Contact Info Cards -->
                <div class="bg-white p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 text-center group border-2 border-transparent hover:border-primary">
                    <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-primary transition-colors">
                        <i class="fas fa-map-marker-alt text-3xl text-primary group-hover:text-white transition-colors"></i>
                    </div>
                    <h4 class="font-bold text-xl text-secondary mb-3 font-handlee">Visit Us</h4>
                    <p class="text-gray-600">{{ $settings->school_address ?? '123 Education Street, Lagos, Nigeria' }}</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 text-center group border-2 border-transparent hover:border-secondary">
                    <div class="w-16 h-16 bg-secondary/10 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-secondary transition-colors">
                        <i class="fas fa-envelope text-3xl text-secondary group-hover:text-white transition-colors"></i>
                    </div>
                    <h4 class="font-bold text-xl text-secondary mb-3 font-handlee">Email Us</h4>
                    <p class="text-gray-600">{{ $settings->school_email ?? 'info@talentupgrade.edu.ng' }}</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 text-center group border-2 border-transparent hover:border-green-500">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-green-500 transition-colors">
                        <i class="fas fa-phone text-3xl text-green-500 group-hover:text-white transition-colors"></i>
                    </div>
                    <h4 class="font-bold text-xl text-secondary mb-3 font-handlee">Call Us</h4>
                    <p class="text-gray-600">{{ $settings->school_phone ?? '+234 123 456 7890' }}</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="max-w-3xl mx-auto mt-12 bg-white p-10 rounded-3xl shadow-xl">
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-bold text-secondary mb-2">Your Name *</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition-colors">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-bold text-secondary mb-2">Your Email *</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition-colors">
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-bold text-secondary mb-2">Subject</label>
                        <input type="text" id="subject" name="subject"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition-colors">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-bold text-secondary mb-2">Message *</label>
                        <textarea id="message" name="message" rows="5" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition-colors resize-none"></textarea>
                    </div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-primary to-secondary text-white py-4 rounded-xl font-bold text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-3 group">
                        <i class="fas fa-paper-plane"></i>
                        Send Message
                        <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-b from-secondary to-blue-900 text-white pt-20 pb-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- About Column -->
                <div>
                    <a href="/" class="flex items-center gap-3 text-white font-bold text-2xl font-handlee mb-6 group">
                        <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center group-hover:rotate-6 transition-transform">
                            <i class="fas fa-graduation-cap text-xl"></i>
                        </div>
                        {{ $settings->school_name ?? 'TalentUpgrade' }}
                    </a>
                    <p class="text-gray-300 leading-relaxed mb-6">
                        Nurturing young minds to reach their full potential through quality education and care.
                    </p>
                    <div class="flex gap-3">
                        @if(isset($settings->social_links) && is_array($settings->social_links))
                            @foreach($settings->social_links as $platform => $link)
                                <a href="{{ $link }}" 
                                   class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-primary hover:scale-110 transition-all duration-300"
                                   aria-label="{{ ucfirst($platform) }}">
                                    <i class="fab fa-{{ $platform }}"></i>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-bold font-handlee mb-6 text-primary">Quick Links</h3>
                    <div class="space-y-3">
                        <a href="#" class="flex items-center gap-2 text-gray-300 hover:text-white hover:translate-x-2 transition-all">
                            <i class="fas fa-chevron-right text-xs text-primary"></i> Home
                        </a>
                        <a href="#about" class="flex items-center gap-2 text-gray-300 hover:text-white hover:translate-x-2 transition-all">
                            <i class="fas fa-chevron-right text-xs text-primary"></i> About Us
                        </a>
                        <a href="#classes" class="flex items-center gap-2 text-gray-300 hover:text-white hover:translate-x-2 transition-all">
                            <i class="fas fa-chevron-right text-xs text-primary"></i> Our Classes
                        </a>
                        <a href="#teachers" class="flex items-center gap-2 text-gray-300 hover:text-white hover:translate-x-2 transition-all">
                            <i class="fas fa-chevron-right text-xs text-primary"></i> Teachers
                        </a>
                        <a href="#contact" class="flex items-center gap-2 text-gray-300 hover:text-white hover:translate-x-2 transition-all">
                            <i class="fas fa-chevron-right text-xs text-primary"></i> Contact
                        </a>
                    </div>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-xl font-bold font-handlee mb-6 text-primary">Contact Info</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                            <p class="text-gray-300 text-sm">{{ $settings->school_address ?? '123 Education Street, Lagos' }}</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-envelope text-primary mt-1"></i>
                            <a href="mailto:{{ $settings->school_email ?? 'info@example.com' }}" class="text-gray-300 text-sm hover:text-white transition">
                                {{ $settings->school_email ?? 'info@example.com' }}
                            </a>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-phone-alt text-primary mt-1"></i>
                            <a href="tel:{{ $settings->school_phone ?? '+234 123 456 7890' }}" class="text-gray-300 text-sm hover:text-white transition">
                                {{ $settings->school_phone ?? '+234 123 456 7890' }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-xl font-bold font-handlee mb-6 text-primary">Newsletter</h3>
                    <p class="text-gray-300 text-sm mb-6">Subscribe to get updates on events and news.</p>
                    <form action="#" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label for="newsletter-name" class="sr-only">Your Name</label>
                            <input type="text" id="newsletter-name" name="name" placeholder="Your Name"
                                class="w-full px-4 py-3 rounded-xl bg-white/10 border-2 border-white/20 text-white placeholder-gray-400 focus:border-primary focus:outline-none transition-colors">
                        </div>
                        <div>
                            <label for="newsletter-email" class="sr-only">Your Email</label>
                            <input type="email" id="newsletter-email" name="email" placeholder="Your Email" required
                                class="w-full px-4 py-3 rounded-xl bg-white/10 border-2 border-white/20 text-white placeholder-gray-400 focus:border-primary focus:outline-none transition-colors">
                        </div>
                        <button type="submit"
                            class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-white hover:text-primary transition-all duration-300 hover:shadow-lg">
                            Subscribe Now
                        </button>
                    </form>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-white/10 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} {{ $settings->school_name ?? 'TalentUpgrade' }}. All Rights Reserved. 
                    <span class="mx-2">|</span>
                    <a href="#" class="hover:text-primary transition">Privacy Policy</a>
                    <span class="mx-2">|</span>
                    <a href="#" class="hover:text-primary transition">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" 
            class="fixed bottom-8 right-8 w-14 h-14 bg-gradient-to-br from-primary to-secondary text-white rounded-full shadow-2xl opacity-0 invisible hover:scale-110 transition-all duration-300 z-50 flex items-center justify-center"
            onclick="scrollToTop()"
            aria-label="Back to top">
        <i class="fas fa-arrow-up text-xl"></i>
    </button>

    <script>
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('active');
        }

        // Close mobile menu when clicking on a link
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobileMenu').classList.remove('active');
            });
        });

        // Back to Top Button
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTop.classList.remove('invisible', 'opacity-0');
                backToTop.classList.add('opacity-100');
            } else {
                backToTop.classList.add('invisible', 'opacity-0');
                backToTop.classList.remove('opacity-100');
            }
        });

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>