<x-master-layout>
    <div class="fade-in space-y-8 pb-12">
        {{-- Hero Welcome Section - Enhanced Visibility --}}
        <div class="relative overflow-hidden rounded-[2rem] p-10 text-white shadow-2xl border border-white/10"
            style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); min-height: 240px;">
            <div class="relative z-20 flex flex-col md:flex-row md:items-center justify-between gap-8 h-full">
                <div class="max-w-2xl">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full border border-white/20 text-xs font-bold uppercase tracking-widest mb-4">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Status: Active Session
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black mb-3 tracking-tight leading-tight">
                        {{ $greeting }}, <span
                            class="bg-clip-text text-transparent bg-gradient-to-r from-white to-indigo-100 italic">{{ auth()->user()->first_name }}</span>!
                    </h1>
                    <p class="text-indigo-50 text-xl font-medium opacity-90 leading-relaxed">
                        Your classroom tools and schedules are ready. Have a productive session today!
                    </p>
                </div>
                <div class="flex items-center gap-6">
                    <div class="hidden md:flex flex-col items-end border-r border-white/20 pr-6">
                        <span class="text-4xl font-black tracking-tighter">{{ now()->format('H:i') }}</span>
                        <span
                            class="text-sm uppercase tracking-widest opacity-70 font-bold">{{ now()->format('l, F j') }}</span>
                    </div>
                    <div
                        class="w-20 h-20 bg-white/20 rounded-[1.5rem] flex items-center justify-center backdrop-blur-xl border border-white/30 text-4xl shadow-lg ring-4 ring-white/5">
                        @if(now()->hour < 18)
                            <i class="fas fa-sun text-yellow-300"></i>
                        @else
                            <i class="fas fa-moon text-indigo-200"></i>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Decorative Abstract Shapes --}}
            <div class="absolute -right-20 -top-20 w-96 h-96 bg-white/5 rounded-full blur-[100px]"></div>
            <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-indigo-400/10 rounded-full blur-[80px]"></div>
            <div
                class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay">
            </div>
        </div>

        {{-- Premium Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Card 1: Messages --}}
            <a href="{{ route('staff.messages.index') }}"
                class="group bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-[0_15px_40px_rgb(0,0,0,0.08)] transition-all duration-500 hover:-translate-y-1 block">
                <div class="flex items-center justify-between mb-5">
                    <div
                        class="p-4 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 shadow-inner">
                        <i class="fas fa-envelope-open-text text-2xl"></i>
                    </div>
                    @if($unreadMessages > 0)
                        <div
                            class="flex items-center gap-1 px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black rounded-lg uppercase tracking-tighter">
                            <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                            Action Required
                        </div>
                    @endif
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-widest">Incoming Inbox</p>
                    <h3 class="text-3xl font-black text-gray-900 leading-none">
                        {{ $unreadMessages }} <span class="text-xs font-bold text-gray-400 opacity-60 ml-1">Unread
                            Msg</span>
                    </h3>
                </div>
            </a>

            {{-- Card 2: Library --}}
            <a href="{{ route('staff.library.index') }}"
                class="group bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-[0_15px_40px_rgb(0,0,0,0.08)] transition-all duration-500 hover:-translate-y-1 block">
                <div class="flex items-center justify-between mb-5">
                    <div
                        class="p-4 bg-amber-50 text-amber-600 rounded-2xl group-hover:bg-amber-600 group-hover:text-white transition-all duration-500 shadow-inner">
                        <i class="fas fa-book-reader text-2xl"></i>
                    </div>
                    @if($pendingLibraryRequests > 0)
                        <div
                            class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-black rounded-lg uppercase tracking-tighter">
                            Reserved
                        </div>
                    @endif
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-widest">Library Queue</p>
                    <h3 class="text-3xl font-black text-gray-900 leading-none">
                        {{ $pendingLibraryRequests }} <span
                            class="text-xs font-bold text-gray-400 opacity-60 ml-1">Requests</span>
                    </h3>
                </div>
            </a>

            {{-- Card 3: Assignments --}}
            <a href="{{ route('staff.assignments.index') }}"
                class="group bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-[0_15px_40px_rgb(0,0,0,0.08)] transition-all duration-500 hover:-translate-y-1 block">
                <div class="flex items-center justify-between mb-5">
                    <div
                        class="p-4 bg-purple-50 text-purple-600 rounded-2xl group-hover:bg-purple-600 group-hover:text-white transition-all duration-500 shadow-inner">
                        <i class="fas fa-tasks text-2xl"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-widest">Academic Tasks</p>
                    <h3 class="text-3xl font-black text-gray-900 leading-none">
                        {{ $totalAssignments }} <span
                            class="text-xs font-bold text-gray-400 opacity-60 ml-1">Assignments</span>
                    </h3>
                </div>
            </a>

            {{-- Card 4: Students --}}
            <a href="{{ route('staff.classes.index') }}"
                class="group bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-[0_15px_40px_rgb(0,0,0,0.08)] transition-all duration-500 hover:-translate-y-1 block">
                <div class="flex items-center justify-between mb-5">
                    <div
                        class="p-4 bg-rose-50 text-rose-600 rounded-2xl group-hover:bg-rose-600 group-hover:text-white transition-all duration-500 shadow-inner">
                        <i class="fas fa-user-graduate text-2xl"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-widest">Enrolled Souls</p>
                    <h3 class="text-3xl font-black text-gray-900 leading-none">
                        {{ $totalStudents }} <span
                            class="text-xs font-bold text-gray-400 opacity-60 ml-1">Students</span>
                    </h3>
                </div>
            </a>
        </div>

        {{-- Interactive Main Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Left Side --}}
            <div class="lg:col-span-8 space-y-8">
                {{-- Alert for Attendance --}}
                @if(isset($pendingTasks) && $pendingTasks > 0)
                    <div
                        class="bg-gradient-to-r from-rose-600 to-pink-600 p-1 rounded-3xl shadow-xl shadow-rose-200 group transform hover:scale-[1.01] transition-all">
                        <div class="bg-white rounded-[1.4rem] p-6 flex flex-col md:flex-row items-center gap-6">
                            <div
                                class="w-16 h-16 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-3xl flex-shrink-0">
                                <i class="fas fa-bell animate-swing"></i>
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <h4 class="text-xl font-black text-gray-900 tracking-tight">Daily Requirement: Attendance
                                </h4>
                                <p class="text-gray-500 font-medium mt-1">Found <strong>{{ $pendingTasks }} classes</strong>
                                    missing today's attendance records.</p>
                            </div>
                            <a href="{{ route('staff.attendance.index') }}"
                                class="w-full md:w-auto px-10 py-4 bg-rose-600 text-white rounded-2xl font-black hover:bg-rose-700 transition-all shadow-lg hover:shadow-rose-300 uppercase tracking-widest text-xs">Mark
                                Now</a>
                        </div>
                    </div>
                @endif

                {{-- Schedule Widget --}}
                <div
                    class="bg-white rounded-[2rem] border border-gray-100 shadow-[0_20px_50px_rgb(0,0,0,0.03)] overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                        <a href="{{ route('staff.timetable.index') }}" class="block hover:opacity-80 transition-opacity">
                            <h2 class="text-2xl font-black text-gray-900">Today's Schedule</h2>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Live Tracking</p>
                        </a>
                        <div class="flex items-center gap-4">
                            <span
                                class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black rounded-lg uppercase tracking-widest">
                                {{ $todaySchedule->count() }} Active Periods
                            </span>
                        </div>
                    </div>
                    <div class="p-8">
                        @forelse($todaySchedule as $period)
                            <div class="flex items-start gap-8 mb-8 last:mb-0 relative group">
                                @if(!$loop->last)
                                    <div
                                        class="absolute left-[1.15rem] top-10 bottom-0 w-[2px] bg-indigo-50 group-hover:bg-indigo-100 transition-colors">
                                    </div>
                                @endif
                                <div class="flex flex-col items-center flex-shrink-0 relative z-10 pt-1">
                                    <div
                                        class="w-10 h-10 rounded-full border-4 border-white bg-indigo-600 shadow-md flex items-center justify-center text-white text-xs font-black">
                                        {{ $loop->iteration }}
                                    </div>
                                    <span
                                        class="mt-2 text-sm font-black text-gray-800">{{ \Carbon\Carbon::parse($period->period->start_time)->format('H:i') }}</span>
                                </div>
                                <div
                                    class="flex-1 p-6 rounded-[1.5rem] border border-gray-100 bg-white hover:border-indigo-200 hover:shadow-xl transition-all duration-300">
                                    <div
                                        class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                                        <div>
                                            <h4 class="font-black text-gray-900 text-xl">{{ $period->subject->name }}</h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span
                                                    class="text-xs font-bold text-indigo-500 uppercase tracking-widest px-2 py-0.5 bg-indigo-50 rounded-md">
                                                    Room: {{ $period->classRoom->name }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 bg-gray-50 p-2 rounded-xl">
                                            <i class="far fa-clock text-gray-400 text-sm"></i>
                                            <span class="text-xs font-black text-gray-600">
                                                {{ \Carbon\Carbon::parse($period->period->start_time)->format('g:i A') }} -
                                                {{ \Carbon\Carbon::parse($period->period->end_time)->format('g:i A') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-3">
                                        <a href="{{ route('staff.classes.show', $period->class_id) }}"
                                            class="px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all">Attend
                                            Students</a>
                                        <a href="{{ route('staff.lesson-plans.create', ['class_id' => $period->class_id, 'subject_id' => $period->subject_id]) }}"
                                            class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-100 transition-all">Prepare
                                            Lesson</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="text-center py-20 bg-gray-50/50 rounded-[2rem] border-2 border-dashed border-gray-100">
                                <div
                                    class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 text-gray-200 shadow-sm">
                                    <i class="fas fa-calendar-day text-4xl"></i>
                                </div>
                                <h5 class="text-xl font-black text-gray-900">Quiet Day Ahead</h5>
                                <p class="text-gray-500 font-medium max-w-xs mx-auto mt-2">No active classes detected in
                                    your schedule for today.</p>
                                <div class="mt-8">
                                    <a href="{{ route('staff.timetable.index') }}"
                                        class="text-indigo-600 font-black text-xs uppercase tracking-widest hover:underline">View
                                        Full Week Schedule &rarr;</a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Right Side --}}
            <div class="lg:col-span-4 space-y-8">
                {{-- Quick Control Mosaic --}}
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('staff.assignments.create') }}"
                        class="flex flex-col items-center justify-center p-6 rounded-[2rem] bg-indigo-50 border border-indigo-100 group transition-all hover:bg-indigo-600">
                        <i class="fas fa-plus text-indigo-600 text-2xl mb-2 group-hover:text-white transition-all"></i>
                        <span
                            class="text-[10px] font-black text-indigo-900 uppercase tracking-widest group-hover:text-white text-center">New
                            Task</span>
                    </a>
                    <a href="{{ route('staff.exam-questions.create') }}"
                        class="flex flex-col items-center justify-center p-6 rounded-[2rem] bg-purple-50 border border-purple-100 group transition-all hover:bg-purple-600">
                        <i
                            class="fas fa-file-pen text-purple-600 text-2xl mb-2 group-hover:text-white transition-all"></i>
                        <span
                            class="text-[10px] font-black text-purple-900 uppercase tracking-widest group-hover:text-white text-center">Exam
                            Prep</span>
                    </a>
                    <a href="{{ route('staff.messages.create') }}"
                        class="flex flex-col items-center justify-center p-6 rounded-[2rem] bg-teal-50 border border-teal-100 group transition-all hover:bg-teal-600">
                        <i
                            class="fas fa-paper-plane text-teal-600 text-2xl mb-2 group-hover:text-white transition-all"></i>
                        <span
                            class="text-[10px] font-black text-teal-900 uppercase tracking-widest group-hover:text-white text-center">Reach
                            Out</span>
                    </a>
                    <a href="{{ route('forum.index') }}"
                        class="flex flex-col items-center justify-center p-6 rounded-[2rem] bg-sky-50 border border-sky-100 group transition-all hover:bg-sky-600">
                        <i class="fas fa-comments text-sky-600 text-2xl mb-2 group-hover:text-white transition-all"></i>
                        <span
                            class="text-[10px] font-black text-sky-900 uppercase tracking-widest group-hover:text-white text-center">Forum</span>
                    </a>
                </div>

                {{-- Modern News Widget --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-[0_20px_50px_rgb(0,0,0,0.03)] p-8">
                    <div class="flex justify-between items-center mb-10">
                        <h2 class="text-2xl font-black text-gray-900">Notices</h2>
                        <span
                            class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center">
                            <i class="fas fa-bullhorn rotate-[15deg]"></i>
                        </span>
                    </div>

                    <div class="space-y-8">
                        @forelse($notices as $notice)
                            <div class="relative group">
                                <div class="flex items-center gap-3 mb-3">
                                    <span
                                        class="text-[9px] font-black uppercase px-2 py-0.5 bg-gray-100 text-gray-500 rounded border border-gray-200">Broadcast</span>
                                    <span
                                        class="text-[9px] font-bold text-gray-400">{{ $notice->created_at->format('M d') }}</span>
                                </div>
                                <h4
                                    class="text-sm font-black text-gray-800 group-hover:text-indigo-600 transition truncate">
                                    {{ $notice->title }}
                                </h4>
                                <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed opacity-80">
                                    {{ $notice->message }}
                                </p>
                            </div>
                        @empty
                            <div class="text-center py-10 opacity-30">
                                <i class="fas fa-feather text-4xl mb-4"></i>
                                <p class="text-xs font-bold uppercase tracking-widest">Quiet Air</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-10 pt-8 border-t border-gray-50">
                        <a href="{{ route('staff.notices.index') }}"
                            class="inline-flex items-center gap-2 text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:gap-4 transition-all">
                            View Bulletin Archive <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Personal Command Center --}}
                <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-indigo-500/30 to-rose-500/30 opacity-0 group-hover:opacity-100 transition-all duration-700">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-5 mb-10">
                            <div
                                class="w-16 h-16 rounded-[1.2rem] bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-3xl font-black shadow-lg shadow-indigo-500/40 transform -rotate-6 group-hover:rotate-0 transition-transform">
                                {{ substr(auth()->user()->username, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-black text-xl tracking-tight">Staff Account</h3>
                                <p class="text-[10px] text-indigo-300 font-black uppercase tracking-widest mt-0.5">
                                    Control Center</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <a href="{{ route('staff.payroll.index') }}"
                                class="flex items-center justify-between p-5 rounded-[1.2rem] bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/20 transition-all">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-indigo-400">
                                        <i class="fas fa-coins"></i>
                                    </div>
                                    <span class="text-sm font-black tracking-tight">My Earnings</span>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] opacity-30"></i>
                            </a>

                            <a href="{{ route('staff.library.index') }}"
                                class="flex items-center justify-between p-5 rounded-[1.2rem] bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/20 transition-all">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-orange-500/20 flex items-center justify-center text-orange-400">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <span class="text-sm font-black tracking-tight">My Library</span>
                                </div>
                                @if($pendingLibraryRequests > 0)
                                    <div
                                        class="w-5 h-5 bg-amber-400 rounded-full flex items-center justify-center text-slate-900 text-[10px] font-black animate-pulse">
                                        !
                                    </div>
                                @else
                                    <i class="fas fa-chevron-right text-[10px] opacity-30"></i>
                                @endif
                            </a>

                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center justify-between p-5 rounded-[1.2rem] bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/20 transition-all">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-rose-500/20 flex items-center justify-center text-rose-400">
                                        <i class="fas fa-gears"></i>
                                    </div>
                                    <span class="text-sm font-black tracking-tight">Security</span>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] opacity-30"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes swing {
            0% {
                transform: rotate(0);
            }

            25% {
                transform: rotate(10deg);
            }

            50% {
                transform: rotate(-10deg);
            }

            75% {
                transform: rotate(5deg);
            }

            100% {
                transform: rotate(0);
            }
        }

        .fade-in {
            animation: fade-in 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-swing {
            animation: swing 2s infinite ease-in-out;
        }

        .font-black {
            font-weight: 950;
        }

        .shadow-inner {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
        }
    </style>
</x-master-layout>