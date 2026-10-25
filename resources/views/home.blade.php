@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Hero Section -->
    <section class="text-center mb-16">
        <h1 class="text-5xl font-bold mb-4 text-gray-900 dark:text-white">
            Welcome to Infospare
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
            Discover amazing features and services designed to help you succeed.
        </p>
        <div class="flex justify-center space-x-4">
            <a href="{{ route('downloads') }}" class="btn btn-primary">
                Downloads
            </a>
            <a href="#" class="btn btn-secondary">
                Learn More
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">Our Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Fast Performance</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Experience lightning-fast performance with our optimized platform.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Secure & Safe</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Your data is protected with enterprise-grade security measures.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">User Friendly</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Intuitive interface designed for ease of use and accessibility.
                </p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 mb-16">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">About Us</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                We are dedicated to providing the best solutions for our customers. Our team of experts works 
                tirelessly to ensure you have the tools and support you need to succeed.
            </p>
            <p class="text-gray-600 dark:text-gray-300">
                With years of experience and a commitment to excellence, we've helped thousands of clients 
                achieve their goals. Join us today and see what we can do for you.
            </p>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="text-center rounded-lg shadow-lg p-12" style="background-color: #F8ECD7;">
        <h2 class="text-3xl font-bold mb-4 text-gray-900">Ready to Get Started?</h2>
        <p class="text-xl mb-8 text-gray-700">
            Join thousands of satisfied customers today.
        </p>
        <a href="{{ route('downloads') }}" class="btn btn-primary">
            Get In Touch
        </a>
    </section>
</div>
@endsection

