<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MTAU HELPDESK')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 flex flex-col">
            <div class="flex items-center justify-center h-16 bg-blue-700">
                <img src="{{ asset('images/removemtau.png') }}" alt="Logo" class="h-10 w-10 mr-2">
                <h1 class="text-xl font-bold">MTAU HELPDESK</h1>
            </div>
            <div class="flex items-center p-4">
                <img alt="User profile picture" class="rounded-full" height="40" src="" width="40"/>
                <div class="ml-4">
                    {{-- <p>{{ Auth::user()->name }}</p> --}}
                    <p class="text-green-500 text-sm">● online</p>
                </div>
            </div>
            <nav class="flex-1 px-2 py-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('tickets.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700">
                    <i class="fas fa-ticket-alt mr-3"></i>
                    Tickets
                </a>
                <a href="{{ route('members.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700">
                    <i class="fas fa-users mr-3"></i>
                    Members
                </a>
                <a href="{{ route('transactions.index') }}" class="flex items-center px-2 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700">
                    <i class="fas fa-chart-line mr-3"></i>
                    Transactions
                </a>
            </nav>
            <div class="text-center text-gray-400 text-xs p-4">
                <p>Copyright © 2023 MTAU. All Right Reserved</p>
                <p>Ver. 2.3.3</p>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <header class="flex items-center justify-end h-16 bg-blue-700 text-white px-4">
                <div class="relative">
                    <div class="flex items-center space-x-4 cursor-pointer" id="profile-toggle">
                        <i class="fas fa-inbox" id="mailbox-icon"></i>
                        <i class="fas fa-bell" id="bell-icon"></i>
                        <div class="flex items-center">
                            <img alt="User profile picture" class="rounded-full" height="40" src="" width="40"/>
                            {{-- <span class="ml-2">{{ Auth::user()->name }}</span> --}}
                        </div>
                    </div>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden" id="profile-menu">
                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-200">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            <main class="flex-1 p-6 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileToggle = document.getElementById('profile-toggle');
            const profileMenu = document.getElementById('profile-menu');
            const mailboxIcon = document.getElementById('mailbox-icon');
            const bellIcon = document.getElementById('bell-icon');

            profileToggle.addEventListener('click', function() {
                profileMenu.classList.toggle('hidden');
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!profileToggle.contains(event.target)) {
                    profileMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html> 