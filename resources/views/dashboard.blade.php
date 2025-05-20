<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Chat - app</title>
    <style>
        @media screen and (max-width: 1100px) {
            #Sidebar {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- component -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="Sidebar" class="w-1/4 bg-white border-r border-gray-300">
            <!-- Sidebar Header -->
            <header class="p-4 border-b border-gray-300 flex justify-between items-center bg-indigo-600 text-white">
                <h1 class="text-2xl font-semibold">Chat Web</h1>
                <div class="relative">
                    <button id="menuButton" class="focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-100" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path d="M2 10a2 2 0 012-2h12a2 2 0 012 2 2 2 0 01-2 2H4a2 2 0 01-2-2z" />
                        </svg>
                    </button>
                    <!-- Menu Dropdown -->
                    <div id="menuDropdown"
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg hidden">
                        <ul class="py-2 px-3">
                            <li><a href="#" class="block px-4 py-2 text-gray-800 hover:text-gray-400">Option 1</a></li>
                            <li><a href="#" class="block px-4 py-2 text-gray-800 hover:text-gray-400">Option 2</a></li>
                            <!-- Add more menu options here -->
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Contact List -->
            <div id="newMessageNotification" class="overflow-y-auto h-screen p-3 mb-9 pb-20">
                @if ($users->count() > 1)
                    @foreach ($users as $user)
                        <a href="{{ route('dashboard', $user->id) }}">
                            <div class="flex items-center mb-4 cursor-pointer hover:bg-gray-100 p-2 rounded-md"
                                data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
                                    <img src="https://placehold.co/200x/ad922e/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato"
                                        alt="User Avatar" class="w-12 h-12 rounded-full">
                                </div>
                                <div class="flex-1">
                                    <div class="flex">
                                        <h2 class="text-lg font-semibold">{{ $user->name }}</h2>
                                        @php
                                            $hasNotification = auth()->user()->unreadNotifications->contains(function ($notification) use ($user) {
                                                return $notification->data['sender_id'] == $user->id;
                                            });
                                         @endphp
                                        @if ($hasNotification)
                                            <i class="fa-solid pt-2 fa-bell"></i>
                                        @endif
                                    </div>
                                    <p class="text-gray-600"> {{ $user->last_message ?? 'No messages yet' }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else

                @endif
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="flex-1">

            <!-- Chat Header -->
            <header class="bg-white p-4 text-gray-700">
                <h1 class="text-2xl font-semibold">{{ $chatWith->name ?? 'select user' }}</h1>
            </header>

            <!-- Chat Messages -->
            <div id="chatMessages" class="h-screen overflow-y-auto p-4 pb-36">
                <!-- Chat Messages -->
                @foreach ($messages as $message)
                    @if ($message->sender_id == auth()->id())
                        <!-- Outgoing message (mine) -->
                        <div class="flex justify-end mb-4">
                            <div class="flex max-w-96 bg-indigo-500 text-white rounded-lg p-3 gap-3">
                                <p>{{ $message->message }}</p>
                            </div>
                            <div class="w-9 h-9 rounded-full flex items-center justify-center ml-2">
                                <img src="https://placehold.co/200x/b7a8ff/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="My Avatar"
                                    class="w-8 h-8 rounded-full">
                            </div>
                        </div>
                    @else
                        <!-- Incoming message (from other user) -->
                        <div class="flex mb-4">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center mr-2">
                                <img src="https://placehold.co/200x/ffa8e4/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar"
                                    class="w-8 h-8 rounded-full">
                            </div>
                            <div class="flex max-w-96 bg-white rounded-lg p-3 gap-3">
                                <p class="text-gray-700">{{ $message->message }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach



            </div>

            <!-- Chat Input -->
            <footer class="bg-white border-t border-gray-300 p-4 absolute bottom-0 w-3/4">
                <div class="flex items-center">
                    <input type="hidden" id="receiver_id" value="{{ $chatWith->id }}" name="receiver_id">
                    <input type="text" id="message" name="message" placeholder="Type a message..."
                        class="w-full p-2 rounded-md border border-gray-400 focus:outline-none focus:border-blue-500">
                    <button type="submit" id="sendMessage"
                        class="bg-indigo-500 text-white px-4 py-2 rounded-md ml-2">Send</button>
                </div>
            </footer>
        </div>
    </div>


    <script src="{{ asset('js.js') }}"></script>
    @vite('resources/js/app.js')
</body>

</html>
