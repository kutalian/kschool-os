<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'School ERP') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-800" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/80 z-40 md:hidden"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white min-h-screen transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto md:block"
            id="sidebar">
            <div class="p-6 border-b border-slate-700 flex items-center justify-between">
                <a href="{{ route('dashboard') }}"
                    class="text-2xl font-bold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">
                    School ERP
                </a>
                <!-- Mobile Close Button -->
                <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="mt-6 px-4 space-y-2">
                <!-- Common Links -->
                <a href="{{ route('dashboard') }}"
                    class="block px-4 py-2.5 rounded hover:bg-slate-800 transition-colors {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-blue-400' : 'text-gray-300' }}">
                    <i class="fas fa-home w-6"></i> Dashboard
                </a>

                @if(auth()->user()->role === 'admin')

                    <!-- Academic Group -->
                    <div x-data="{ open: {{ request()->routeIs('classes.*', 'subjects.*', 'syllabus.*', 'assignments.*', 'timetable.*') ? 'true' : 'false' }} }"
                        class="mt-2">
                        <button @click="open = !open"
                            class="flex items-center justify-between w-full px-4 py-2.5 rounded hover:bg-slate-800 text-gray-300 transition-colors"
                            :class="open ? 'bg-slate-800/50' : ''">
                            <span class="flex items-center">
                                <i class="fas fa-graduation-cap w-6"></i> Academic
                            </span>
                            <i :class="open ? 'rotate-180' : ''"
                                class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 mt-1 space-y-1">
                            <a href="{{ route('classes.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('classes.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Classes
                            </a>
                            <a href="{{ route('subjects.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('subjects.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Subjects
                            </a>
                            <a href="{{ route('syllabus.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('syllabus.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Syllabus
                            </a>
                            <a href="{{ route('assignments.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('assignments.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Assignments
                            </a>
                            <a href="{{ route('lesson-plans.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('lesson-plans.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Lesson Plans
                            </a>
                            <a href="{{ route('timetable.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('timetable.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Timetable
                            </a>
                        </div>
                    </div>

                    <!-- Students Group -->
                    <div x-data="{ open: {{ request()->routeIs('students.*', 'parents.*', 'attendance.*') ? 'true' : 'false' }} }"
                        class="mt-1">
                        <button @click="open = !open"
                            class="flex items-center justify-between w-full px-4 py-2.5 rounded hover:bg-slate-800 text-gray-300 transition-colors"
                            :class="open ? 'bg-slate-800/50' : ''">
                            <span class="flex items-center">
                                <i class="fas fa-user-graduate w-6"></i> Students
                            </span>
                            <i :class="open ? 'rotate-180' : ''"
                                class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 mt-1 space-y-1">
                            <a href="{{ route('students.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('students.index', 'students.show', 'students.edit') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Students List
                            </a>
                            <a href="{{ route('students.create') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('students.create') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Add Student
                            </a>
                            <a href="{{ route('students.promotion') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('students.promotion') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Promote Students
                            </a>
                            <a href="{{ route('parents.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('parents.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Parents
                            </a>
                            <a href="{{ route('attendance.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('attendance.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Attendance
                            </a>
                        </div>
                    </div>

                    <!-- Examinations Group -->
                    <div x-data="{ open: {{ request()->routeIs('exams.*', 'exam-schedule.*', 'marks.*', 'reports.*', 'grades.*') ? 'true' : 'false' }} }"
                        class="mt-1">
                        <button @click="open = !open"
                            class="flex items-center justify-between w-full px-4 py-2.5 rounded hover:bg-slate-800 text-gray-300 transition-colors"
                            :class="open ? 'bg-slate-800/50' : ''">
                            <span class="flex items-center">
                                <i class="fas fa-file-alt w-6"></i> Examinations
                            </span>
                            <i :class="open ? 'rotate-180' : ''"
                                class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 mt-1 space-y-1">
                            <a href="{{ route('exams.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('exams.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Exams List
                            </a>
                            <a href="{{ route('exam-schedule.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('exam-schedule.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Schedule
                            </a>
                            <a href="{{ route('marks.create') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('marks.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Enter Marks
                            </a>
                            <a href="{{ route('reports.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('reports.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Report Cards
                            </a>
                            <a href="{{ route('grades.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('grades.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Grade Settings
                            </a>
                        </div>
                    </div>

                    <!-- Human Resources Group -->
                    <div x-data="{ open: {{ request()->routeIs('staff.*', 'staff-attendance.*', 'performance-reviews.*', 'users.*') ? 'true' : 'false' }} }"
                        class="mt-1">
                        <button @click="open = !open"
                            class="flex items-center justify-between w-full px-4 py-2.5 rounded hover:bg-slate-800 text-gray-300 transition-colors"
                            :class="open ? 'bg-slate-800/50' : ''">
                            <span class="flex items-center">
                                <i class="fas fa-users w-6"></i> Human Resources
                            </span>
                            <i :class="open ? 'rotate-180' : ''"
                                class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 mt-1 space-y-1">
                            <a href="{{ route('staff.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('staff.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Staff Directory
                            </a>
                            <a href="{{ route('staff-attendance.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('staff-attendance.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Staff Attendance
                            </a>
                            <a href="{{ route('performance-reviews.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('performance-reviews.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Performance
                            </a>
                            <a href="{{ route('users.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('users.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                System Users
                            </a>
                        </div>
                    </div>

                    <!-- Financial Group -->
                    <div x-data="{ open: {{ request()->routeIs('fees.*', 'expenses.*', 'payroll.*') ? 'true' : 'false' }} }"
                        class="mt-1">
                        <button @click="open = !open"
                            class="flex items-center justify-between w-full px-4 py-2.5 rounded hover:bg-slate-800 text-gray-300 transition-colors"
                            :class="open ? 'bg-slate-800/50' : ''">
                            <span class="flex items-center">
                                <i class="fas fa-wallet w-6"></i> Financial
                            </span>
                            <i :class="open ? 'rotate-180' : ''"
                                class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 mt-1 space-y-1">
                            <a href="{{ route('fees.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('fees.index', 'fees.create', 'fees.edit') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Fee Types
                            </a>
                            <a href="{{ route('fees.assign') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('fees.assign') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Assign Fees
                            </a>
                            <a href="{{ route('fees.collect') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('fees.collect') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Collect Fees
                            </a>
                            <a href="{{ route('fees.report') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('fees.report') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Fee Reports
                            </a>
                            <a href="{{ route('expenses.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('expenses.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Expenses
                            </a>
                            <a href="{{ route('payroll.index') }}"
                                class="block px-4 py-2 rounded text-sm hover:text-white transition-colors {{ request()->routeIs('payroll.*') ? 'text-blue-400 font-medium' : 'text-gray-400' }}">
                                Payroll
                            </a>
                        </div>
                    </div>

                    <!-- Transport Link (Standalone) -->
                    <a href="{{ route('transport.index') }}"
                        class="block mt-1 px-4 py-2.5 rounded hover:bg-slate-800 transition-colors {{ request()->routeIs('transport.*') ? 'bg-slate-800 text-blue-400' : 'text-gray-300' }}">
                        <i class="fas fa-bus w-6"></i> Transport
                    </a>

                    <!-- Library Link (Standalone) -->
                    <a href="{{ route('library.index') }}"
                        class="block mt-1 px-4 py-2.5 rounded hover:bg-slate-800 transition-colors {{ request()->routeIs('library.*') ? 'bg-slate-800 text-blue-400' : 'text-gray-300' }}">
                        <i class="fas fa-book-reader w-6"></i> Library
                    </a>

                @endif

                @if(auth()->user()->role === 'staff')
                    <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Academic</div>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-slate-800 transition-colors text-gray-300">
                        <i class="fas fa-book w-6"></i> My Classes
                    </a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-slate-800 transition-colors text-gray-300">
                        <i class="fas fa-calendar-alt w-6"></i> Timetable
                    </a>
                @endif

                @if(auth()->user()->role === 'student')
                    <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Student Area</div>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-slate-800 transition-colors text-gray-300">
                        <i class="fas fa-book-open w-6"></i> My Subjects
                    </a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-slate-800 transition-colors text-gray-300">
                        <i class="fas fa-chart-line w-6"></i> Grades
                    </a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-slate-800 transition-colors text-gray-300">
                        <i class="fas fa-graduation-cap w-6"></i> Exams
                    </a>
                @endif

                @if(auth()->user()->role === 'parent')
                    <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Parent Area</div>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-slate-800 transition-colors text-gray-300">
                        <i class="fas fa-child w-6"></i> My Children
                    </a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-slate-800 transition-colors text-gray-300">
                        <i class="fas fa-money-bill-wave w-6"></i> Fees
                    </a>
                @endif

                <div class="pt-4 border-t border-slate-700 mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block px-4 py-2.5 rounded hover:bg-red-900/50 text-red-400 hover:text-red-300 transition-colors">
                            <i class="fas fa-sign-out-alt w-6"></i> Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300">
            <!-- Topbar -->
            <header
                class="bg-white shadow-sm border-b border-gray-200 h-16 flex items-center justify-between px-6 lg:px-8">
                <button @click="sidebarOpen = true"
                    class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="flex items-center gap-4 ml-auto">
                    <button class="text-gray-400 hover:text-blue-500 transition-colors relative">
                        <i class="far fa-bell text-xl"></i>
                        <span
                            class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-red-500"></span>
                    </button>

                    <div class="relative ml-3" x-data="{ open: false }">
                        <button @click="open = ! open" @click.outside="open = false"
                            class="flex items-center gap-2 text-sm focus:outline-none">
                            <div
                                class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200">
                                {{ substr(auth()->user()->username, 0, 1) }}
                            </div>
                            <span
                                class="hidden md:inline font-medium text-gray-700">{{ auth()->user()->username }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            style="display: none;">

                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm text-gray-500">Signed in as</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Your Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Settings</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 lg:p-8 overflow-y-auto">
                {{-- Global Flash Messages --}}
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm"
                        role="alert">
                        <div class="flex">
                            <i class="fas fa-check-circle mt-1 mr-3"></i>
                            <div>
                                <p class="font-bold">Success</p>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle mt-1 mr-3"></i>
                            <div>
                                <p class="font-bold">Error</p>
                                <p>{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>