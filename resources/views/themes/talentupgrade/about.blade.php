@extends('themes.talentupgrade.layout')

@section('content')
    <!-- Page Header -->
    <div class="container-fluid bg-primary mb-5 py-5">
        <div class="container py-5">
            <h1 class="display-3 text-white font-handlee mb-3 animate__animated animate__fadeInDown">About Us</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="/">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">About</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- About Section -->
    <div class="container mx-auto px-6 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=2000&auto=format&fit=crop"
                    class="w-full rounded-2xl shadow-xl" alt="About Us">
                <div class="absolute -bottom-6 -right-6 bg-secondary text-white p-8 rounded-2xl hidden md:block">
                    <h3 class="text-4xl font-bold font-handlee">25+</h3>
                    <p class="text-sm">Years of Experience</p>
                </div>
            </div>
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-12 h-0.5 bg-primary"></div>
                    <p class="text-primary font-bold font-handlee text-xl">Our History</p>
                </div>
                <h2 class="text-4xl font-bold text-secondary font-handlee mb-6 leading-tight">
                    Innovating Education Since 1999
                </h2>
                <p class="text-gray-600 mb-6 text-lg leading-relaxed">
                    {{ $themeConfig['about']['content'] ?? 'Founded with a vision to provide quality education for children, our institution has grown to become a leader in early childhood development.' }}
                </p>

                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-primary flex-shrink-0">
                            <i class="fas fa-bullseye text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-secondary">Our Mission</h4>
                            <p class="text-gray-500 text-sm">To provide a safe and nurturing environment that fosters
                                learning and growth.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center text-green-500 flex-shrink-0">
                            <i class="fas fa-eye text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-secondary">Our Vision</h4>
                            <p class="text-gray-500 text-sm">To be the most trusted educational partner for parents in our
                                community.</p>
                        </div>
                    </div>
                </div>

                <a href="#contact"
                    class="bg-primary text-white px-8 py-3 rounded-full font-bold hover:bg-secondary transition shadow-md inline-block">Learn
                    More</a>
            </div>
        </div>
    </div>
@endsection