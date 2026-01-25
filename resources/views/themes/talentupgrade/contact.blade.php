@extends('themes.talentupgrade.layout')

@section('content')
    <!-- Page Header -->
    <div class="container-fluid bg-primary mb-5 py-5">
        <div class="container py-5">
            <h1 class="display-3 text-white font-handlee mb-3">Contact Us</h1>
            <p class="text-white opacity-80">We'd love to hear from you. Get in touch with us!</p>
        </div>
    </div>

    <div class="container mx-auto px-6 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
            <!-- Contact Info -->
            <div>
                <h2 class="text-3xl font-bold text-secondary font-handlee mb-8">Get In Touch</h2>
                <div class="space-y-6">
                    <div class="flex items-center gap-6">
                        <div
                            class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-primary text-2xl">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-secondary">Our Office</h4>
                            <p class="text-gray-500">{{ $settings->school_address ?? '123 Street, New York, USA' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div
                            class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-500 text-2xl">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-secondary">Email Us</h4>
                            <p class="text-gray-500">{{ $settings->school_email ?? 'info@example.com' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div
                            class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-500 text-2xl">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-secondary">Call Us</h4>
                            <p class="text-gray-500">{{ $settings->school_phone ?? '+012 345 6789' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Simple Map Placeholder -->
                <div
                    class="mt-12 rounded-2xl overflow-hidden shadow-lg border-4 border-white h-64 bg-gray-200 flex items-center justify-center">
                    <div class="text-center text-gray-400">
                        <i class="fas fa-map-marked-alt text-4xl mb-2"></i>
                        <p>Interactive Map Loading...</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-gray-50 p-10 rounded-3xl shadow-sm border border-gray-100">
                <form action="#" method="POST" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-secondary mb-2">First Name</label>
                            <input type="text"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm"
                                placeholder="John">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-secondary mb-2">Last Name</label>
                            <input type="text"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm"
                                placeholder="Doe">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-secondary mb-2">Email Address</label>
                        <input type="email"
                            class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm"
                            placeholder="john@example.com">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-secondary mb-2">Subject</label>
                        <input type="text"
                            class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm"
                            placeholder="Inquiry about admission">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-secondary mb-2">Message</label>
                        <textarea rows="5"
                            class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm"
                            placeholder="How can we help you?"></textarea>
                    </div>
                    <button type="submit"
                        class="w-full bg-secondary text-white font-bold py-4 rounded-xl hover:bg-primary transition shadow-lg transform hover:-translate-y-1">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection