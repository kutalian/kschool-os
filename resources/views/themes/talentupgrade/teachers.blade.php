@extends('themes.talentupgrade.layout')

@section('content')
    <!-- Page Header -->
    <div class="container-fluid bg-primary mb-5 py-5">
        <div class="container py-5">
            <h1 class="display-3 text-white font-handlee mb-3">Our Teachers</h1>
            <p class="text-white opacity-80 text-xl font-handlee">Meet the dedicated team shaping the future leaders.</p>
        </div>
    </div>

    <div class="container mx-auto px-6 py-20">
        <div class="text-center mb-20">
            <h2 class="text-4xl font-bold text-secondary font-handlee mb-4 border-b-4 border-primary inline-block pb-2">Meet
                Our Expert Faculty</h2>
            <p class="text-gray-500 mt-6 max-w-3xl mx-auto text-lg italic">"A good teacher can inspire hope, ignite the
                imagination, and instill a love of learning." Our team is composed of passionate professionals dedicated to
                child-centric education.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            @forelse($teachers as $teacher)
                <div
                    class="group relative bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden text-center p-8 transition duration-500 hover:shadow-2xl hover:-translate-y-2">
                    <div class="absolute top-0 left-0 w-full h-2 bg-primary"></div>

                    <div
                        class="relative w-40 h-40 mx-auto mb-8 rounded-full overflow-hidden border-8 border-gray-50 shadow-inner">
                        @if($teacher->profile_pic)
                            <img src="{{ asset($teacher->profile_pic) }}"
                                class="w-full h-full object-cover transition duration-500 group-hover:scale-110"
                                alt="{{ $teacher->name }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&background=17a2b8&color=fff&size=200"
                                class="w-full h-full object-cover" alt="{{ $teacher->name }}">
                        @endif
                    </div>

                    <h4 class="text-2xl font-bold text-secondary font-handlee mb-1">{{ $teacher->name }}</h4>
                    <p class="text-primary font-bold text-sm uppercase tracking-widest mb-4">
                        {{ $teacher->role_type ?? 'Educator' }}
                    </p>

                    <div
                        class="flex justify-center gap-4 py-4 border-t border-gray-50 mt-4 opacity-0 group-hover:opacity-100 transition duration-500">
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-primary hover:text-white transition"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center hover:bg-primary hover:text-white transition"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-blue-50 text-blue-800 flex items-center justify-center hover:bg-primary hover:text-white transition"><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 bg-gray-50 rounded-3xl text-center border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 font-handlee text-xl italic">Our team is currently being assembled. Stay tuned!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Stats Banner -->
    <div class="bg-secondary py-20 text-white mt-12">
        <div class="container mx-auto px-6 grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
                <h3 class="text-5xl font-bold font-handlee text-primary mb-2">20+</h3>
                <p class="text-sm font-bold opacity-70 uppercase tracking-widest">Skilled Teachers</p>
            </div>
            <div>
                <h3 class="text-5xl font-bold font-handlee text-primary mb-2">500+</h3>
                <p class="text-sm font-bold opacity-70 uppercase tracking-widest">Happy Students</p>
            </div>
            <div>
                <h3 class="text-5xl font-bold font-handlee text-primary mb-2">15+</h3>
                <p class="text-sm font-bold opacity-70 uppercase tracking-widest">Total Classes</p>
            </div>
            <div>
                <h3 class="text-5xl font-bold font-handlee text-primary mb-2">10+</h3>
                <p class="text-sm font-bold opacity-70 uppercase tracking-widest">Years Legend</p>
            </div>
        </div>
    </div>
@endsection