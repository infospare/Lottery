@extends('layouts.app')

@section('title', 'Services')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold mb-4 text-gray-900 dark:text-white">
            Our Services
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            Discover the comprehensive range of services we offer to help your business thrive.
        </p>
    </div>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
        <!-- Service 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Web Development</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                Custom web applications built with modern technologies, responsive design, and optimal performance.
            </p>
            <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                <li>• Responsive Design</li>
                <li>• Custom Solutions</li>
                <li>• Performance Optimization</li>
            </ul>
        </div>

        <!-- Service 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Mobile Applications</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                Native and cross-platform mobile apps that deliver exceptional user experiences on iOS and Android.
            </p>
            <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                <li>• iOS Development</li>
                <li>• Android Development</li>
                <li>• Cross-Platform Solutions</li>
            </ul>
        </div>

        <!-- Service 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">UI/UX Design</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                Beautiful, intuitive interfaces designed with user experience and accessibility in mind.
            </p>
            <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                <li>• User Research</li>
                <li>• Prototyping</li>
                <li>• Design Systems</li>
            </ul>
        </div>

        <!-- Service 4 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Cloud Solutions</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                Scalable cloud infrastructure and migration services to modernize your IT environment.
            </p>
            <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                <li>• Cloud Migration</li>
                <li>• Infrastructure Setup</li>
                <li>• DevOps Services</li>
            </ul>
        </div>

        <!-- Service 5 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
            <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Consulting</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                Expert guidance and strategic advice to help you make informed technology decisions.
            </p>
            <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                <li>• Technology Strategy</li>
                <li>• Architecture Review</li>
                <li>• Best Practices</li>
            </ul>
        </div>

        <!-- Service 6 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Support & Maintenance</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                Ongoing support, maintenance, and updates to keep your systems running smoothly.
            </p>
            <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                <li>• 24/7 Support</li>
                <li>• Regular Updates</li>
                <li>• Performance Monitoring</li>
            </ul>
        </div>
    </div>

    <!-- CTA Section -->
    <section class="text-center bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg p-12 text-white">
        <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-xl mb-8 opacity-90">
            Let's discuss how we can help you achieve your goals.
        </p>
        <a href="{{ route('contact') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
            Contact Us
        </a>
    </section>
</div>
@endsection

