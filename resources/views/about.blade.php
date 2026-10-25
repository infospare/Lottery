@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold mb-4 text-gray-900 dark:text-white">
            About Us
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            Learn more about our mission, values, and the team behind our success.
        </p>
    </div>

    <!-- Mission Section -->
    <section class="mb-16">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">Our Mission</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                We are dedicated to providing exceptional solutions and services that help our clients achieve their goals. 
                Our mission is to deliver innovative, reliable, and user-friendly products that make a positive impact 
                on businesses and individuals worldwide.
            </p>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                With a commitment to excellence and customer satisfaction, we strive to be the trusted partner you 
                can rely on for all your needs.
            </p>
        </div>
    </section>

    <!-- Values Section -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">Our Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Value 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Integrity</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    We conduct business with honesty, transparency, and ethical practices in everything we do.
                </p>
            </div>

            <!-- Value 2 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Innovation</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    We embrace new technologies and creative solutions to stay ahead of the curve.
                </p>
            </div>

            <!-- Value 3 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Customer Focus</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Your success is our priority. We listen, adapt, and deliver solutions tailored to your needs.
                </p>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">Our Team</h2>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <p class="text-gray-600 dark:text-gray-300 text-center leading-relaxed max-w-3xl mx-auto">
                Our team consists of passionate professionals with diverse expertise and a shared commitment to excellence. 
                We work collaboratively to bring you the best solutions, combining years of experience with fresh perspectives 
                and innovative thinking. Together, we're building the future of technology and service excellence.
            </p>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="text-center bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg p-12 text-white">
        <h2 class="text-3xl font-bold mb-4">Want to Learn More?</h2>
        <p class="text-xl mb-8 opacity-90">
            Get in touch with us to discover how we can help you achieve your goals.
        </p>
        <a href="{{ route('contact') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
            Contact Us
        </a>
    </section>
</div>
@endsection

