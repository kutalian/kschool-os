@extends('themes.talentupgrade.layout')

@section('content')

    @foreach($sections as $section)
        {{-- Hero Section --}}
        @if($section->section_key === 'hero')
            <div class="relative bg-gradient-to-br from-primary via-primary to-blue-400 px-0 px-md-5 mb-5 overflow-hidden">
                {{-- Animated Background Elements --}}
                <div class="absolute inset-0 overflow-hidden">
                    <div
                        class="absolute top-20 left-10 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob">
                    </div>
                    <div
                        class="absolute top-40 right-10 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000">
                    </div>
                    <div
                        class="absolute -bottom-8 left-40 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000">
                    </div>
                </div>

                <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center py-24 relative z-10">
                    <div class="animate-fade-in-up">
                        <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full mb-6">
                            <span class="w-2 h-2 bg-yellow-300 rounded-full animate-pulse"></span>
                            <h4 class="text-white font-handlee tracking-widest uppercase font-bold text-sm">
                                🎓 Kids Learning Center
                            </h4>
                        </div>
                        <h1 class="text-5xl md:text-7xl text-white font-bold font-handlee mb-6 leading-tight drop-shadow-lg">
                            {{ $section->title }}
                        </h1>
                        <p class="text-white text-xl mb-8 leading-relaxed drop-shadow">
                            {{ $section->content }}
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ $section->action_url }}"
                                class="group bg-secondary text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-secondary transition-all duration-300 shadow-2xl hover:shadow-secondary/50 hover:scale-105 flex items-center gap-2">
                                {{ $section->action_text }}
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="#about"
                                class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-primary transition-all duration-300 border-2 border-white/50">
                                Learn More
                            </a>
                        </div>
                    </div>
                    <div class="relative animate-fade-in-right">
                        <div
                            class="absolute -inset-4 bg-gradient-to-r from-yellow-300 to-pink-300 rounded-full blur-2xl opacity-30 animate-pulse">
                        </div>
                        @if($section->image_path)
                            <img class="relative w-full max-w-lg mx-auto rounded-full shadow-2xl border-8 border-white/30 hover:scale-105 transition-transform duration-500"
                                src="{{ $section->image_path }}" alt="Happy children learning" loading="eager">
                        @else
                            <img class="relative w-full max-w-lg mx-auto rounded-full shadow-2xl border-8 border-white/30 hover:scale-105 transition-transform duration-500"
                                src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&auto=format&fit=crop&q=80"
                                alt="Happy children learning" loading="eager">
                        @endif
                    </div>
                </div>

                {{-- Wave Divider --}}
                <div class="absolute bottom-0 left-0 w-full">
                    <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"
                            fill="white" />
                    </svg>
                </div>
            </div>
        @endif

        {{-- Facilities Section --}}
        @if($section->section_key === 'facilities')
            <div class="container mx-auto px-6 py-16 -mt-12">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $facilities = [
                            ['icon' => 'bus', 'title' => 'School Bus', 'color' => 'red', 'delay' => '0'],
                            ['icon' => 'futbol', 'title' => 'Playground', 'color' => 'green', 'delay' => '100'],
                            ['icon' => 'utensils', 'title' => 'Healthy Canteen', 'color' => 'yellow', 'delay' => '200'],
                            ['icon' => 'chalkboard-teacher', 'title' => 'Positive Learning', 'color' => 'blue', 'delay' => '300'],
                        ];
                    @endphp

                    @foreach($facilities as $facility)
                        <div class="group bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 text-center border-2 border-transparent hover:border-{{ $facility['color'] }}-400 transform hover:-translate-y-2 animate-fade-in-up"
                            style="animation-delay: {{ $facility['delay'] }}ms">
                            <div class="relative mb-6 inline-block">
                                <div
                                    class="w-24 h-24 bg-{{ $facility['color'] }}-100 rounded-2xl flex items-center justify-center group-hover:bg-{{ $facility['color'] }}-500 transition-all duration-300 group-hover:rotate-6 group-hover:scale-110">
                                    <i
                                        class="fas fa-{{ $facility['icon'] }} text-4xl text-{{ $facility['color'] }}-500 group-hover:text-white transition-colors duration-300"></i>
                                </div>
                                <div
                                    class="absolute -top-2 -right-2 w-6 h-6 bg-{{ $facility['color'] }}-400 rounded-full opacity-0 group-hover:opacity-100 animate-ping">
                                </div>
                            </div>
                            <h4
                                class="font-bold font-handlee text-2xl text-secondary mb-3 group-hover:text-{{ $facility['color'] }}-600 transition-colors">
                                {{ $facility['title'] }}
                            </h4>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                @if($loop->last && $section->content)
                                    {{ Str::limit($section->content, 80) }}
                                @else
                                    Providing the best environment for your child's growth and development.
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- About Section --}}
        @if($section->section_key === 'about')
            <div id="about" class="container mx-auto px-6 py-24 relative">
                {{-- Decorative Elements --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -z-10"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-secondary/5 rounded-full -z-10"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                    <div class="relative animate-fade-in-left">
                        @if($section->image_path)
                            <div class="relative">
                                <div class="absolute -inset-4 bg-gradient-to-r from-primary to-secondary rounded-3xl blur opacity-20">
                                </div>
                                <img src="{{ $section->image_path }}"
                                    class="relative w-full rounded-3xl shadow-2xl hover:scale-105 transition-transform duration-500"
                                    alt="About {{ $settings->school_name ?? 'our school' }}" loading="lazy">
                            </div>
                        @else
                            <div class="grid grid-cols-2 gap-6">
                                <img class="rounded-3xl w-full mt-12 shadow-xl hover:scale-105 transition-transform duration-500"
                                    src="https://images.unsplash.com/photo-1588072432836-e10032774350?w=500&auto=format&fit=crop&q=80"
                                    alt="Students learning together" loading="lazy">
                                <img class="rounded-3xl w-full shadow-xl hover:scale-105 transition-transform duration-500"
                                    src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=500&auto=format&fit=crop&q=80"
                                    alt="Classroom activities" loading="lazy">
                            </div>
                        @endif

                        {{-- Floating Stats Card --}}
                        <div
                            class="absolute -bottom-8 -right-8 bg-white p-6 rounded-2xl shadow-2xl border-t-4 border-primary hidden md:block animate-float">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-users text-3xl text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="text-3xl font-bold text-secondary font-handlee">500+</h4>
                                    <p class="text-gray-500 text-sm">Happy Students</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="animate-fade-in-up">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-16 h-1 bg-gradient-to-r from-primary to-transparent rounded-full"></div>
                            <p class="text-primary font-bold font-handlee text-xl tracking-wide">Learn About Us</p>
                        </div>
                        <h2 class="text-5xl md:text-6xl font-bold text-secondary font-handlee mb-6 leading-tight">
                            {{ $section->title }}
                        </h2>
                        <p class="text-gray-600 mb-8 text-lg leading-relaxed">
                            {!! nl2br(e($section->content)) !!}
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                            @php
                                $features = [
                                    ['icon' => 'user-graduate', 'text' => 'Skilled Teachers', 'color' => 'primary'],
                                    ['icon' => 'lightbulb', 'text' => 'Active Learning', 'color' => 'secondary'],
                                    ['icon' => 'smile', 'text' => 'Fun & Happy', 'color' => 'yellow-500'],
                                    ['icon' => 'hands-helping', 'text' => 'Parent Support', 'color' => 'green-500'],
                                ];
                            @endphp

                            @foreach($features as $feature)
                                <div class="flex items-center gap-4 group">
                                    <div
                                        class="w-14 h-14 bg-{{ $feature['color'] }}/10 rounded-2xl flex items-center justify-center group-hover:bg-{{ $feature['color'] }} transition-all duration-300 group-hover:rotate-6">
                                        <i
                                            class="fas fa-{{ $feature['icon'] }} text-xl text-{{ $feature['color'] }} group-hover:text-white transition-colors"></i>
                                    </div>
                                    <span class="font-bold text-secondary text-lg">{{ $feature['text'] }}</span>
                                </div>
                            @endforeach
                        </div>

                        <a href="{{ $section->action_url ?? '#contact' }}"
                            class="inline-flex items-center gap-3 bg-gradient-to-r from-primary to-blue-500 text-white px-10 py-4 rounded-full font-bold hover:shadow-2xl hover:scale-105 transition-all duration-300 group">
                            {{ $section->action_text ?? 'Discover More' }}
                            <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Call To Action --}}
        @if($section->section_key === 'cta' || $section->section_key === 'become_teacher')
            <div class="relative bg-gradient-to-r from-secondary via-blue-900 to-secondary py-24 text-white overflow-hidden my-16">
                {{-- Animated Background Pattern --}}
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-full h-full"
                        style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                    </div>
                </div>

                <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10">
                    <div class="animate-fade-in-up">
                        <div class="inline-block bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full mb-4">
                            <span class="text-yellow-300 text-sm font-bold">✨ Join Our Team</span>
                        </div>
                        <h2 class="text-5xl font-bold font-handlee mb-6 leading-tight">{{ $section->title }}</h2>
                        <p class="mb-8 opacity-90 text-lg leading-relaxed">{{ $section->content }}</p>
                        <a href="{{ $section->action_url }}"
                            class="inline-flex items-center gap-3 bg-white text-secondary px-10 py-4 rounded-full font-bold hover:bg-primary hover:text-white transition-all duration-300 shadow-2xl hover:shadow-white/20 hover:scale-105 group">
                            {{ $section->action_text }}
                            <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                        </a>
                    </div>
                    <div class="relative hidden md:block animate-fade-in-right">
                        <div class="absolute -inset-4 bg-primary/30 rounded-full blur-2xl"></div>
                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400&auto=format&fit=crop&q=80"
                            class="relative rounded-full border-8 border-white/20 w-96 h-96 object-cover ml-auto shadow-2xl hover:scale-105 transition-transform duration-500"
                            alt="Inspiring teacher" loading="lazy">
                    </div>
                </div>
            </div>
        @endif

        {{-- Classes --}}
        @if($section->section_key === 'classes')
            <div id="classes" class="container mx-auto px-6 py-24">
                <div class="text-center mb-16 animate-fade-in-up">
                    <div class="inline-block bg-primary/10 px-6 py-2 rounded-full mb-4">
                        <p class="text-primary font-bold font-handlee text-xl">📚 Our Curriculum</p>
                    </div>
                    <h2 class="text-5xl md:text-6xl font-bold text-secondary font-handlee mb-4">{{ $section->title }}</h2>
                    <p class="text-gray-500 text-lg mt-6 max-w-3xl mx-auto leading-relaxed">
                        We offer a comprehensive curriculum from Pre-Kindergarten to Secondary School, designed to nurture every
                        child's potential.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @php
                        $classes = [
                            [
                                'title' => 'Interactive Learning',
                                'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&auto=format&fit=crop&q=80',
                                'icon' => 'laptop',
                                'color' => 'blue',
                                'description' => 'Engaging digital and hands-on activities'
                            ],
                            [
                                'title' => 'Creative Arts',
                                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=600&auto=format&fit=crop&q=80',
                                'icon' => 'palette',
                                'color' => 'pink',
                                'description' => 'Express yourself through art and music'
                            ],
                            [
                                'title' => 'Academic Excellence',
                                'image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=600&auto=format&fit=crop&q=80',
                                'icon' => 'graduation-cap',
                                'color' => 'green',
                                'description' => 'Building strong foundations for success'
                            ],
                        ];
                    @endphp

                    @foreach($classes as $index => $class)
                        <div class="group relative rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 animate-fade-in-up hover:-translate-y-2"
                            style="animation-delay: {{ $index * 100 }}ms">
                            <div class="relative h-96 overflow-hidden">
                                <img src="{{ $class['image'] }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                    alt="{{ $class['title'] }}" loading="lazy">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300">
                                </div>
                            </div>

                            <div class="absolute inset-0 flex flex-col justify-end p-8">
                                <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                    <div
                                        class="w-16 h-16 bg-{{ $class['color'] }}-500 rounded-2xl flex items-center justify-center mb-4 group-hover:rotate-6 transition-transform duration-300">
                                        <i class="fas fa-{{ $class['icon'] }} text-2xl text-white"></i>
                                    </div>
                                    <h3 class="text-white font-bold font-handlee text-3xl mb-2">{{ $class['title'] }}</h3>
                                    <p
                                        class="text-white/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                                        {{ $class['description'] }}
                                    </p>
                                </div>
                            </div>

                            {{-- Hover Arrow --}}
                            <div
                                class="absolute top-6 right-6 w-12 h-12 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform -translate-y-2 group-hover:translate-y-0">
                                <i class="fas fa-arrow-right text-{{ $class['color'] }}-500"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Registration / Book Seat --}}
        @if($section->section_key === 'registration')
            <div id="join"
                class="relative bg-gradient-to-br from-primary via-blue-500 to-primary text-white py-24 my-16 overflow-hidden">
                {{-- Animated Background --}}
                <div class="absolute inset-0">
                    <div class="absolute top-20 left-10 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-blob"></div>
                    <div
                        class="absolute bottom-20 right-10 w-96 h-96 bg-yellow-300/10 rounded-full blur-3xl animate-blob animation-delay-2000">
                    </div>
                </div>

                <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10">
                    <div class="animate-fade-in-up">
                        <div class="inline-block bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full mb-4">
                            <p class="text-yellow-300 font-bold font-handlee text-lg">🎯 Enrollment Open</p>
                        </div>
                        <h2 class="text-5xl font-bold font-handlee mb-6 leading-tight">{{ $section->title }}</h2>
                        <p class="mb-8 text-white/90 text-lg leading-relaxed">{{ $section->content }}</p>

                        <ul class="space-y-4 mb-10">
                            @php
                                $benefits = [
                                    'Expert teachers with years of experience',
                                    'Modern facilities and learning resources',
                                    'Safe and nurturing environment',
                                    'Regular parent-teacher communication'
                                ];
                            @endphp
                            @foreach($benefits as $benefit)
                                <li class="flex items-center gap-4 group">
                                    <div
                                        class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                    <span class="text-lg">{{ $benefit }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="animate-fade-in-right">
                        <div class="relative bg-white p-10 md:p-12 rounded-3xl shadow-2xl overflow-hidden">
                            {{-- Decorative Corner --}}
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-primary/20 to-transparent rounded-bl-full">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-secondary/20 to-transparent rounded-tr-full">
                            </div>

                            <div class="relative text-center">
                                <div
                                    class="w-20 h-20 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center mx-auto mb-6 animate-bounce-slow">
                                    <i class="fas fa-user-graduate text-3xl text-white"></i>
                                </div>
                                <h3 class="text-4xl font-bold font-handlee mb-4 text-secondary">Register Today!</h3>
                                <p class="text-gray-600 mb-8 leading-relaxed">
                                    Registration is done physically at the school. Book an appointment to visit our facilities and
                                    meet our team.
                                </p>

                                <a href="#contact"
                                    class="group inline-flex items-center justify-center gap-3 w-full bg-gradient-to-r from-primary to-secondary text-white font-bold py-5 rounded-2xl hover:shadow-2xl transition-all duration-300 hover:scale-105 uppercase tracking-wide text-lg">
                                    <i class="fas fa-calendar-check"></i>
                                    Book Appointment
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                </a>

                                <p class="text-gray-500 text-sm mt-6">
                                    <i class="fas fa-phone text-primary"></i> Or call us:
                                    <strong>{{ $settings->school_phone ?? '+234 123 456 7890' }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Teachers Section --}}
        @if($section->section_key === 'teachers' || $section->section_key === 'about')
            @if($loop->last && $section->section_key !== 'teachers' && $section->section_key !== 'testimonials')
                <div id="teachers" class="container mx-auto px-6 py-24">
                    <div class="text-center mb-16 animate-fade-in-up">
                        <div class="inline-block bg-primary/10 px-6 py-2 rounded-full mb-4">
                            <p class="text-primary font-bold font-handlee text-xl">👨‍🏫 Our Teachers</p>
                        </div>
                        <h2 class="text-5xl md:text-6xl font-bold text-secondary font-handlee">Meet Our Expert Team</h2>
                        <p class="text-gray-500 text-lg mt-4 max-w-2xl mx-auto">
                            Passionate educators dedicated to nurturing young minds
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @if(isset($teachers) && $teachers->count() > 0)
                            @foreach($teachers as $index => $teacher)
                                <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl p-6 text-center transition-all duration-500 hover:-translate-y-2 border-2 border-transparent hover:border-primary animate-fade-in-up"
                                    style="animation-delay: {{ $index * 100 }}ms">
                                    <div
                                        class="relative w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-gray-100 group-hover:border-primary transition-all duration-300">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-primary/20 to-secondary/20 opacity-0 group-hover:opacity-100 transition-opacity">
                                        </div>
                                        @if($teacher->profile_pic)
                                            <img src="{{ $teacher->profile_pic }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                alt="{{ $teacher->name }}" loading="lazy">
                                        @else
                                            <img src="{{ asset('images/defaults/teacher-' . (($index % 4) + 1) . '.jpg') }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                alt="{{ $teacher->name }}" loading="lazy">
                                        @endif
                                    </div>
                                    <h4 class="font-bold font-handlee text-2xl mb-2 text-secondary group-hover:text-primary transition-colors">
                                        {{ $teacher->name }}
                                    </h4>
                                    <p class="text-gray-500 text-sm uppercase tracking-wide mb-4 group-hover:text-secondary transition-colors">
                                        {{ $teacher->role_type ?? 'Teacher' }}
                                    </p>
                                    <div class="flex justify-center gap-3 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                        <a href="#"
                                            class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors"
                                            aria-label="Twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="#"
                                            class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors"
                                            aria-label="Facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="#"
                                            class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors"
                                            aria-label="LinkedIn">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- Static Fallback Teachers --}}
                            @php
                                $staticTeachers = [
                                    ['name' => 'Julia Smith', 'role' => 'Music Teacher', 'img' => 'https://images.unsplash.com/photo-1580894732444-8ecded7900cd?w=300&auto=format&fit=crop&q=80'],
                                    ['name' => 'John Doe', 'role' => 'Language Teacher', 'img' => 'https://images.unsplash.com/photo-1521235042493-c5bef0bdea9c?w=300&auto=format&fit=crop&q=80'],
                                    ['name' => 'Mollie Ross', 'role' => 'Dance Teacher', 'img' => 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=300&auto=format&fit=crop&q=80'],
                                    ['name' => 'Sarah Johnson', 'role' => 'Art Teacher', 'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&auto=format&fit=crop&q=80'],
                                ];
                            @endphp
                            @foreach($staticTeachers as $index => $teacher)
                                <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl p-6 text-center transition-all duration-500 hover:-translate-y-2 border-2 border-transparent hover:border-primary animate-fade-in-up"
                                    style="animation-delay: {{ $index * 100 }}ms">
                                    <div
                                        class="relative w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-gray-100 group-hover:border-primary transition-all duration-300">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-primary/20 to-secondary/20 opacity-0 group-hover:opacity-100 transition-opacity">
                                        </div>
                                        <img src="{{ $teacher['img'] }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                            alt="{{ $teacher['name'] }}" loading="lazy">
                                    </div>
                                    <h4 class="font-bold font-handlee text-2xl mb-2 text-secondary group-hover:text-primary transition-colors">
                                        {{ $teacher['name'] }}
                                    </h4>
                                    <p class="text-gray-500 text-sm uppercase tracking-wide mb-4 group-hover:text-secondary transition-colors">
                                        {{ $teacher['role'] }}
                                    </p>
                                    <div class="flex justify-center gap-3 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                        <a href="#"
                                            class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors"
                                            aria-label="Twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="#"
                                            class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors"
                                            aria-label="Facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="#"
                                            class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors"
                                            aria-label="LinkedIn">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Testimonials Section --}}
                <div class="bg-gradient-to-b from-gray-50 to-white py-24">
                    <div class="container mx-auto px-6">
                        <div class="text-center mb-16 animate-fade-in-up">
                            <div class="inline-block bg-primary/10 px-6 py-2 rounded-full mb-4">
                                <p class="text-primary font-bold font-handlee text-xl">💬 Testimonials</p>
                            </div>
                            <h2 class="text-5xl md:text-6xl font-bold text-secondary font-handlee">What Parents Say!</h2>
                            <p class="text-gray-500 text-lg mt-4 max-w-2xl mx-auto">
                                Hear from the families who trust us with their children's education
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            @php
                                $testimonials = [
                                    [
                                        'quote' => 'The teachers are incredibly caring and professional. My daughter has grown so much both academically and socially. Best decision we ever made!',
                                        'name' => 'Sarah Williams',
                                        'role' => 'Parent of Emily',
                                        'image' => 'https://randomuser.me/api/portraits/women/44.jpg',
                                        'color' => 'primary',
                                        'delay' => '0'
                                    ],
                                    [
                                        'quote' => 'Outstanding facilities and a nurturing environment. The staff goes above and beyond to ensure every child reaches their potential.',
                                        'name' => 'Michael Chen',
                                        'role' => 'Parent of David',
                                        'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
                                        'color' => 'secondary',
                                        'delay' => '100'
                                    ],
                                    [
                                        'quote' => 'We love the diverse curriculum and the emphasis on both academics and character development. Highly recommended!',
                                        'name' => 'Jessica Brown',
                                        'role' => 'Parent of Sophie',
                                        'image' => 'https://randomuser.me/api/portraits/women/11.jpg',
                                        'color' => 'green-500',
                                        'delay' => '200'
                                    ],
                                ];
                            @endphp

                            @foreach($testimonials as $testimonial)
                                <div class="relative bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border-t-4 border-{{ $testimonial['color'] }} hover:-translate-y-2 animate-fade-in-up"
                                    style="animation-delay: {{ $testimonial['delay'] }}ms">
                                    {{-- Quote Icon --}}
                                    <div
                                        class="absolute -top-6 left-8 w-12 h-12 bg-{{ $testimonial['color'] }} rounded-full flex items-center justify-center shadow-lg">
                                        <i class="fas fa-quote-left text-white text-xl"></i>
                                    </div>

                                    <div class="mt-6">
                                        {{-- Stars Rating --}}
                                        <div class="flex gap-1 mb-4">
                                            @for($i = 0; $i < 5; $i++)
                                                <i class="fas fa-star text-yellow-400"></i>
                                            @endfor
                                        </div>

                                        <p class="text-gray-600 italic mb-6 leading-relaxed">
                                            "{{ $testimonial['quote'] }}"
                                        </p>

                                        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                                            <img src="{{ $testimonial['image'] }}"
                                                class="w-14 h-14 rounded-full border-2 border-{{ $testimonial['color'] }}/30 shadow-md"
                                                alt="{{ $testimonial['name'] }}" loading="lazy">
                                            <div>
                                                <h5 class="font-bold font-handlee text-lg text-secondary">{{ $testimonial['name'] }}</h5>
                                                <span
                                                    class="text-xs text-gray-500 uppercase tracking-wide">{{ $testimonial['role'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endif

    @endforeach

@endsection