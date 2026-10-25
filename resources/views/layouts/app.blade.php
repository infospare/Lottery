<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Infospare'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .btn {
            display: inline-block;
            padding: 0.3rem 0.65rem;
            border-radius: 0.375rem;
            font-weight: 600;
            font-size: 0.75rem;
            line-height: 1.4;
            border: none;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            text-align: center;
            color: #ffffff;
            box-sizing: border-box;
            transition: background-color 0.15s ease;
        }
        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        .btn-primary {
            background-color: #2563eb;
        }
        .btn-primary:hover:not(:disabled) {
            background-color: #1d4ed8;
        }
        .btn-danger {
            background-color: #dc2626;
        }
        .btn-danger:hover:not(:disabled) {
            background-color: #b91c1c;
        }
        .btn-secondary {
            background-color: #e5e7eb;
            color: #1f2937;
        }
        .btn-secondary:hover:not(:disabled) {
            background-color: #d1d5db;
        }
        .btn-block {
            width: 100%;
            display: block;
        }
        input,
        textarea,
        select {
            color: #111827;
            background-color: #ffffff;
            -webkit-text-fill-color: #111827;
            color-scheme: light;
            font-size: 16px;
            opacity: 1;
            caret-color: #111827;
        }
        input::placeholder,
        textarea::placeholder {
            color: #6b7280;
            -webkit-text-fill-color: #6b7280;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')
</body>
</html>

