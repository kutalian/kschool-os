@extends('themes.talentupgrade.layout')

@section('content')
    <!-- Page Header -->
    <div class="container-fluid bg-primary mb-5 py-5">
        <div class="container py-5">
            <h1 class="display-3 text-white font-handlee mb-3">Our Classes</h1>
            <p class="text-white opacity-80 text-xl font-handlee">Comprehensive curriculum for every stage of development.
            </p>
        </div>
    </div>

    <div class="container mx-auto px-6 py-20">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-secondary font-handlee mb-4">Choose The Right Class For Your Child</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">We offer a variety of programs tailored to different age groups and
                learning styles, focusing on holistic development.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($classes as $class)
                <div
                    class="bg-white rounded-3xl shadow-lg overflow-hidden group hover:shadow-2xl transition duration-500 border border-gray-100 flex flex-col">
                    <div class="relative h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=1000&auto=format&fit=crop"
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-110"
                            alt="{{ $class->name }}">
                        <div class="absolute top-4 left-4 bg-primary text-white font-bold px-4 py-1 rounded-full text-sm">
                            {{ $class->category ?? 'General' }}
                        </div>
                    </div>
                    <div class="p-8 flex-1">
                        <h4 class="text-2xl font-bold text-secondary font-handlee mb-3 capitalize">{{ $class->name }}</h4>
                        <p class="text-gray-600 mb-6 line-clamp-3">
                            {{ $class->description ?? 'Discover our exciting core curriculum designed to spark curiosity and build a strong academic foundation.' }}
                        </p>

                        <div class="grid grid-cols-2 gap-4 border-t border-gray-100 pt-6 mb-6">
                            <div>
                                <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Age Group</span>
                                <p class="text-secondary font-bold">{{ $class->age_group ?? '3-5 Years' }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Total Seats</span>
                                <p class="text-secondary font-bold">{{ $class->capacity ?? '25 Seats' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-8 pt-0 mt-auto">
                        <a href="/p/contact"
                            class="block w-full text-center bg-secondary text-white font-bold py-4 rounded-2xl hover:bg-primary transition shadow-md">
                            Join Now
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 text-gray-400">
                    <i class="fas fa-search text-5xl mb-4"></i>
                    <p class="text-xl">No classes found in the system.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Registration Callout -->
    <div class="bg-blue-600 py-16 text-white text-center">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold font-handlee mb-6">Want to enroll your child?</h2>
            <p class="mb-10 text-xl text-blue-100 opacity-90 max-w-2xl mx-auto">Registration for the new academic session is
                now open. Seats are limited, so book your appointment today!</p>
            <a href="/p/contact"
                class="bg-white text-blue-600 font-bold px-10 py-4 rounded-full hover:bg-yellow-400 hover:text-white transition shadow-xl text-lg">
                Register Your Child Now
            </a>
        </div>
    </div>
@endsection