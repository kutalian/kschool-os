@extends('themes.talentupgrade.layout')

@section('content')

    @foreach($sections as $section)
        {{-- Hero Section --}}
        @if($section->section_key === 'hero')
            <div class="container-fluid bg-primary px-0 px-md-5 mb-5">
                <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center py-24">
                    <div>
                        <h4 class="text-white font-handlee mb-4 tracking-widest uppercase font-bold text-xl">Kids Learning Center
                        </h4>
                        <h1 class="text-6xl text-white font-bold font-handlee mb-6 leading-tight">{{ $section->title }}</h1>
                        <p class="text-white mb-8 text-lg font-medium opacity-90">{{ $section->content }}</p>
                        <a href="{{ $section->action_url }}"
                            class="bg-secondary text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-secondary transition shadow-lg border-2 border-secondary hover:border-white">{{ $section->action_text }}</a>
                    </div>
                    <div class="relative">
                        @if($section->image_path)
                            <img class="w-full max-w-lg mx-auto rounded-full shadow-2xl border-[10px] border-white/20"
                                src="{{ asset($section->image_path) }}" alt="Hero Image">
                        @else
                            <img class="w-full max-w-lg mx-auto rounded-full shadow-2xl border-[10px] border-white/20"
                                src="https://via.placeholder.com/600x600" alt="Hero Image">
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- Facilities Section --}}
        @if($section->section_key === 'facilities')
            <div class="container mx-auto px-6 py-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    {{-- Static Items for Design Match --}}
                    <div
                        class="bg-gray-50 p-8 rounded-full shadow-md hover:shadow-xl transition text-center group border border-gray-100 h-80 flex flex-col items-center justify-center">
                        <div
                            class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-red-500 transition">
                            <i class="fas fa-bus text-4xl text-red-500 group-hover:text-white transition"></i>
                        </div>
                        <h4 class="font-bold font-handlee text-xl text-secondary mb-2">School Bus</h4>
                        <p class="text-gray-500 text-sm px-4">Kasd labore kasd et dolor est rebum dolor ut, clita dolor vero lorem
                            amet elitr vero...</p>
                    </div>

                    <div
                        class="bg-gray-50 p-8 rounded-full shadow-md hover:shadow-xl transition text-center group border border-gray-100 h-80 flex flex-col items-center justify-center">
                        <div
                            class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-green-500 transition">
                            <i class="fas fa-futbol text-4xl text-green-500 group-hover:text-white transition"></i>
                        </div>
                        <h4 class="font-bold font-handlee text-xl text-secondary mb-2">Playground</h4>
                        <p class="text-gray-500 text-sm px-4">Kasd labore kasd et dolor est rebum dolor ut, clita dolor vero lorem
                            amet elitr vero...</p>
                    </div>

                    <div
                        class="bg-gray-50 p-8 rounded-full shadow-md hover:shadow-xl transition text-center group border border-gray-100 h-80 flex flex-col items-center justify-center">
                        <div
                            class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-yellow-500 transition">
                            <i class="fas fa-home text-4xl text-yellow-500 group-hover:text-white transition"></i>
                        </div>
                        <h4 class="font-bold font-handlee text-xl text-secondary mb-2">Healthy Canteen</h4>
                        <p class="text-gray-500 text-sm px-4">Kasd labore kasd et dolor est rebum dolor ut, clita dolor vero lorem
                            amet elitr vero...</p>
                    </div>

                    <div
                        class="bg-gray-50 p-8 rounded-full shadow-md hover:shadow-xl transition text-center group border border-gray-100 h-80 flex flex-col items-center justify-center">
                        <div
                            class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-blue-500 transition">
                            <i class="fas fa-chalkboard-teacher text-4xl text-blue-500 group-hover:text-white transition"></i>
                        </div>
                        <h4 class="font-bold font-handlee text-xl text-secondary mb-2">Positive Learning</h4>
                        <p class="text-gray-500 text-sm px-4">{{ Str::limit($section->content, 60) }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- About Section --}}
        @if($section->section_key === 'about')
            <div id="about" class="container mx-auto px-6 py-20">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div class="relative">
                        @if($section->image_path)
                            <img src="{{ asset($section->image_path) }}" class="w-full rounded-2xl shadow-xl" alt="About Us">
                        @else
                            <div class="grid grid-cols-2 gap-4">
                                <img class="rounded-full w-full mt-12"
                                    src="https://images.unsplash.com/photo-1588072432836-e10032774350?w=500&auto=format&fit=crop&q=60"
                                    alt="">
                                <img class="rounded-full w-full"
                                    src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=500&auto=format&fit=crop&q=60"
                                    alt="">
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-12 h-0.5 bg-primary"></div>
                            <p class="text-primary font-bold font-handlee text-xl">Learn About Us</p>
                        </div>
                        <h2 class="text-4xl md:text-5xl font-bold text-secondary font-handlee mb-6 leading-tight">
                            {{ $section->title }}
                        </h2>
                        <p class="text-gray-600 mb-6 text-lg">
                            {!! nl2br(e($section->content)) !!}
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-primary"><i
                                        class="fas fa-check"></i></div>
                                <span class="font-bold text-secondary">Skilled Teachers</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-primary"><i
                                        class="fas fa-check"></i></div>
                                <span class="font-bold text-secondary">Active Learning</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-primary"><i
                                        class="fas fa-check"></i></div>
                                <span class="font-bold text-secondary">Funny & Happy</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-primary"><i
                                        class="fas fa-check"></i></div>
                                <span class="font-bold text-secondary">Parent Support</span>
                            </div>
                        </div>
                        <a href="{{ $section->action_url ?? '#' }}"
                            class="bg-primary text-white px-8 py-3 rounded-full font-bold hover:bg-secondary transition shadow-md">{{ $section->action_text ?? 'Read More' }}</a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Call To Action --}}
        @if($section->section_key === 'cta' || $section->section_key === 'become_teacher')
            <div class="bg-secondary py-20 text-white relative overflow-hidden my-12">
                {{-- Decorative circles could go here --}}
                <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10">
                    <div>
                        <h2 class="text-4xl font-bold font-handlee mb-4">{{ $section->title }}</h2>
                        <p class="mb-8 opacity-90">{{ $section->content }}</p>
                        <a href="{{ $section->action_url }}"
                            class="bg-white text-secondary px-8 py-3 rounded-full font-bold hover:bg-primary hover:text-white transition shadow-lg">{{ $section->action_text }}</a>
                    </div>
                    <div class="hidden md:block">
                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=2000&auto=format&fit=crop"
                            class="rounded-full border-8 border-white w-80 h-80 object-cover ml-auto" alt="Teacher">
                    </div>
                </div>
            </div>
        @endif

        {{-- Classes --}}
        @if($section->section_key === 'classes')
            <div id="classes" class="container mx-auto px-6 py-20">
                <div class="text-center mb-12 relative">
                    <p class="text-primary font-bold font-handlee text-xl relative z-10 inline-block px-4 bg-white">Our Curriculum
                    </p>
                    <h2 class="text-4xl font-bold text-secondary font-handlee mt-2">{{ $section->title }}</h2>
                    <p class="text-gray-500 mt-4 max-w-2xl mx-auto">We offer a comprehensive curriculum from Pre-Kindergarten to
                        Secondary School, designed to nurture every child's potential.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="rounded-2xl shadow-lg run overflow-hidden h-80 group relative">
                        <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=1000&auto=format&fit=crop"
                            class="w-full h-full object-cover transition duration-300 group-hover:scale-110"
                            alt="Students Learning">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                            <h3 class="text-white font-bold font-handlee text-2xl">Interactive Learning</h3>
                        </div>
                    </div>
                    <div class="rounded-2xl shadow-lg overflow-hidden h-80 group relative">
                        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1000&auto=format&fit=crop"
                            class="w-full h-full object-cover transition duration-300 group-hover:scale-110"
                            alt="Classroom Activity">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                            <h3 class="text-white font-bold font-handlee text-2xl">Creative Arts</h3>
                        </div>
                    </div>
                    <div class="rounded-2xl shadow-lg overflow-hidden h-80 group relative">
                        <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=1000&auto=format&fit=crop"
                            class="w-full h-full object-cover transition duration-300 group-hover:scale-110" alt="Group Study">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                            <h3 class="text-white font-bold font-handlee text-2xl">Academic Excellence</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Registration / Book Seat --}}
        @if($section->section_key === 'registration')
            <div id="join" class="bg-primary text-white py-20 my-10">
                <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div>
                        <p class="text-white/80 font-bold font-handlee text-xl mb-2">Register Your Children</p>
                        <h2 class="text-4xl font-bold font-handlee mb-6">{{ $section->title }}</h2>
                        <p class="mb-8 text-white/90 leading-relaxed">{{ $section->content }}</p>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3"><i class="fas fa-check-circle text-secondary text-xl"></i> Labore
                                eos amet dolor amet diam</li>
                            <li class="flex items-center gap-3"><i class="fas fa-check-circle text-secondary text-xl"></i> Etsea et
                                sit dolor amet ipsum</li>
                            <li class="flex items-center gap-3"><i class="fas fa-check-circle text-secondary text-xl"></i> Diam
                                dolor diam elitripsum vero.</li>
                        </ul>
                    </div>
                    <div>
                        <div class="bg-secondary p-10 rounded-2xl shadow-2xl relative overflow-hidden text-center">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-primary/20 rounded-bl-full"></div>
                            <h3 class="text-3xl font-bold font-handlee mb-8 text-white">Register Your Children</h3>

                            <p class="text-white/80 mb-8">Registration is done physically at the school. Please book an appointment
                                to visit us.</p>

                            <a href="#contact"
                                class="inline-block w-full bg-primary text-white font-bold py-4 rounded-lg hover:bg-white hover:text-primary transition shadow-lg uppercase tracking-wide">
                                Book Appointment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Teachers Section --}}
        @if($section->section_key === 'teachers' || $section->section_key === 'about')
            @if($loop->last && $section->section_key !== 'teachers' && $section->section_key !== 'testimonials')
                <div id="teachers" class="container mx-auto px-6 py-20">
                    <div class="text-center mb-16">
                        <p class="text-primary font-bold font-handlee text-xl inline-block px-4 relative z-10 bg-white">Our Teachers</p>
                        <h2 class="text-4xl font-bold text-secondary font-handlee mt-2">Meet Our Teachers</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        @if(isset($teachers) && $teachers->count() > 0)
                            @foreach($teachers as $teacher)
                                <div
                                    class="bg-white rounded-xl shadow-lg p-6 text-center group hover:bg-secondary hover:text-white transition duration-300">
                                    <div
                                        class="relative w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-gray-100 group-hover:border-primary/50 transition">
                                        @if($teacher->profile_pic)
                                            <img src="{{ $teacher->profile_pic }}" class="w-full h-full object-cover" alt="{{ $teacher->name }}">
                                        @else
                                            <img src="https://source.unsplash.com/random/200x200?teacher&sig={{ $teacher->id }}"
                                                class="w-full h-full object-cover" alt="{{ $teacher->name }}">
                                        @endif
                                    </div>
                                    <h4 class="font-bold font-handlee text-xl mb-1">{{ $teacher->name }}</h4>
                                    <p class="text-gray-500 text-sm group-hover:text-white/80 transition uppercase">
                                        {{ $teacher->role_type ?? 'Teacher' }}
                                    </p>
                                    <div class="flex justify-center gap-3 mt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="#" class="text-white hover:text-primary"><i class="fab fa-twitter"></i></a>
                                        <a href="#" class="text-white hover:text-primary"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#" class="text-white hover:text-primary"><i class="fab fa-linkedin-in"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- Static Fallback --}}
                            <div
                                class="bg-white rounded-xl shadow-lg p-6 text-center group hover:bg-secondary hover:text-white transition duration-300">
                                <div
                                    class="relative w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-gray-100 group-hover:border-primary/50 transition">
                                    <img src="https://images.unsplash.com/photo-1580894732444-8ecded7900cd?w=500&auto=format&fit=crop"
                                        class="w-full h-full object-cover" alt="">
                                </div>
                                <h4 class="font-bold font-handlee text-xl mb-1">Julia Smith</h4>
                                <p class="text-gray-500 text-sm group-hover:text-white/80 transition">Music Teacher</p>
                            </div>
                            <div
                                class="bg-white rounded-xl shadow-lg p-6 text-center group hover:bg-secondary hover:text-white transition duration-300">
                                <div
                                    class="relative w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-gray-100 group-hover:border-primary/50 transition">
                                    <img src="https://images.unsplash.com/photo-1521235042493-c5bef0bdea9c?w=500&auto=format&fit=crop"
                                        class="w-full h-full object-cover" alt="">
                                </div>
                                <h4 class="font-bold font-handlee text-xl mb-1">Jhon Doe</h4>
                                <p class="text-gray-500 text-sm group-hover:text-white/80 transition">Language Teacher</p>
                            </div>
                            <div
                                class="bg-white rounded-xl shadow-lg p-6 text-center group hover:bg-secondary hover:text-white transition duration-300">
                                <div
                                    class="relative w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-gray-100 group-hover:border-primary/50 transition">
                                    <img src="https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=500&auto=format&fit=crop"
                                        class="w-full h-full object-cover" alt="">
                                </div>
                                <h4 class="font-bold font-handlee text-xl mb-1">Mollie Ross</h4>
                                <p class="text-gray-500 text-sm group-hover:text-white/80 transition">Dance Teacher</p>
                            </div>
                            <div
                                class="bg-white rounded-xl shadow-lg p-6 text-center group hover:bg-secondary hover:text-white transition duration-300">
                                <div
                                    class="relative w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-gray-100 group-hover:border-primary/50 transition">
                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=500&auto=format&fit=crop"
                                        class="w-full h-full object-cover" alt="">
                                </div>
                                <h4 class="font-bold font-handlee text-xl mb-1">Donald John</h4>
                                <p class="text-gray-500 text-sm group-hover:text-white/80 transition">Art Teacher</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Testimonials --}}
                <div class="container mx-auto px-6 py-20">
                    <div class="text-center mb-16">
                        <p class="text-primary font-bold font-handlee text-xl inline-block px-4 relative z-10 bg-white">Testimonial</p>
                        <h2 class="text-4xl font-bold text-secondary font-handlee mt-2">What Parents Say!</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="bg-gray-50 p-8 rounded-2xl shadow relative mt-10 border-t-4 border-primary">
                            <i class="fas fa-quote-left text-4xl text-primary/20 absolute top-4 left-4"></i>
                            <p class="text-gray-600 italic mb-6 relative z-10">"Sed ea amet kasd elitr stet, stet rebum et ipsum est duo
                                elitr eirmod clita lorem. Dolor tempor ipsum sanct clita"</p>
                            <div class="flex items-center gap-4">
                                <img src="https://randomuser.me/api/portraits/women/11.jpg"
                                    class="w-16 h-16 rounded-full border-2 border-white shadow" alt="">
                                <div>
                                    <h5 class="font-bold font-handlee text-secondary">Parent Name</h5>
                                    <span class="text-xs text-gray-500">Profession</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-8 rounded-2xl shadow relative mt-10 border-t-4 border-secondary">
                            <i class="fas fa-quote-left text-4xl text-secondary/20 absolute top-4 left-4"></i>
                            <p class="text-gray-600 italic mb-6 relative z-10">"Sed ea amet kasd elitr stet, stet rebum et ipsum est duo
                                elitr eirmod clita lorem. Dolor tempor ipsum sanct clita"</p>
                            <div class="flex items-center gap-4">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg"
                                    class="w-16 h-16 rounded-full border-2 border-white shadow" alt="">
                                <div>
                                    <h5 class="font-bold font-handlee text-secondary">Parent Name</h5>
                                    <span class="text-xs text-gray-500">Profession</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-8 rounded-2xl shadow relative mt-10 border-t-4 border-primary">
                            <i class="fas fa-quote-left text-4xl text-primary/20 absolute top-4 left-4"></i>
                            <p class="text-gray-600 italic mb-6 relative z-10">"Sed ea amet kasd elitr stet, stet rebum et ipsum est duo
                                elitr eirmod clita lorem. Dolor tempor ipsum sanct clita"</p>
                            <div class="flex items-center gap-4">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                    class="w-16 h-16 rounded-full border-2 border-white shadow" alt="">
                                <div>
                                    <h5 class="font-bold font-handlee text-secondary">Parent Name</h5>
                                    <span class="text-xs text-gray-500">Profession</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

    @endforeach

@endsection