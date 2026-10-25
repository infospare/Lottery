@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold mb-4 text-gray-900 dark:text-white">
            Contact Us
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            Get in touch with us. We'd love to hear from you and answer any questions you may have.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
        <!-- Contact Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Send us a Message</h2>
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Name
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Subject
                    </label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Message
                    </label>
                    <textarea id="message" name="message" rows="5" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    Send Message
                </button>
            </form>
        </div>

        <!-- Contact Information -->
        <div class="space-y-8">
            <!-- Contact Details -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Contact Information</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Email</h3>
                            <a href="mailto:info@infospare.in" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                                info@infospare.in
                            </a>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Phone</h3>
                            <a href="tel:+15551234567" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                                +91 7559022205
                            </a>
                        </div>
                    </div>
                    <!-- <div class="flex items-start">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Address</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Opp. Lekshmi Cinimas<br>
                                kodungallur, thrissur, kerala 680664<br>
                                India
                            </p>
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- Business Hours -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Business Hours</h2>
                <div class="space-y-2 text-gray-600 dark:text-gray-300">
                    <div class="flex justify-between">
                        <span>Monday - Friday</span>
                        <span class="font-semibold">9:00 AM - 6:00 PM</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Saturday</span>
                        <span class="font-semibold">10:00 AM - 4:00 PM</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Sunday</span>
                        <span class="font-semibold">Closed</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

