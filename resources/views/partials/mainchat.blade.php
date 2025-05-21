<div class="flex-1">

    <!-- Chat Header -->
    <header class="bg-white p-4 text-gray-700">

        <div class="flex items-center space-x-2">
            <div class="relative">
                <button id="menuButton" class="focus:outline-none">
                    <i id="menuButtonIcon" class="fa-solid fa-bars"></i>
                </button>
            </div>
            @if (isset($chatWith))
                <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200">
                    <img id="nav-profile-pic" src="{{ asset('storage/' . $chatWith->imagePath)}}" alt="Profile"
                        class="w-full h-full object-cover">
                </div>
                <span class="text-sm font-medium text-gray-700">{{ $chatWith->name ?? '' }}</span>
            @endif
        </div>

        <div class="flex">
            <i class="fa-solid pt-2 pr-5 fa-bell"></i>
            <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200">
                <a href="{{ route('profile.index') }}"><img id="nav-profile-pic"
                        src="{{ asset('storage/' . Auth::user()->imagePath) }}" alt="Profile"
                        class="w-full h-full object-cover"></a>
            </div>
        </div>

    </header>

    <!-- Chat Messages -->
    <div id="chatMessages" class="h-screen overflow-y-auto p-4 pb-36">
        <!-- Chat Messages -->
        @if (isset($messages))

            @foreach ($messages as $message)
                @if ($message->sender_id == auth()->id())
                    <!-- Outgoing message (mine) -->
                    <div class="flex justify-end mb-4">
                        <div class="flex max-w-96 bg-indigo-500 text-white rounded-lg p-3 gap-3">
                            <p>{{ $message->message }}</p>
                            <span class="pt-3" style="font-size: 10px">{{ $message->created_at->format('g:i A') }}</span>
                        </div>
                        <div class="w-9 h-9 rounded-full flex items-center justify-center ml-2">
                            <img src="{{ asset('storage/' . Auth::user()->imagePath) }}" alt="My Avatar"
                                class="w-8 h-8 rounded-full">
                        </div>
                    </div>
                @else
                    <!-- Incoming message (from other user) -->
                    <div class="flex mb-4">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center mr-2">
                            <img src="{{ asset('storage/' . $chatWith->imagePath)}}" alt="User Avatar" class="w-8 h-8 rounded-full">
                        </div>
                        <div class="flex max-w-96 bg-white rounded-lg p-3 gap-3">
                            <p class="text-gray-700">{{ $message->message }}</p>
                            <span class="pt-3" style="font-size: 10px">{{ $message->created_at->format('g:i A') }}</span>
                        </div>
                    </div>
                @endif
            @endforeach

        @else
            <div class="text-center p-4 bg-gray-300  border-gray-300">
                <h1>select user to caht wite</h1>
            </div>
        @endif
    </div>

    <!-- Chat Input -->
    @if (isset($messages))
        <footer class="bg-white border-t border-gray-300 p-4 absolute bottom-0 w-3/4">
            <div class="flex items-center">
                <input type="hidden" id="receiver_id" value="{{ $chatWith->id }}" name="receiver_id">
                <input type="text" id="message" name="message" placeholder="Type a message..."
                    class="w-full p-2 rounded-md border border-gray-400 focus:outline-none focus:border-blue-500">
                <button type="submit" id="sendMessage"
                    class="bg-indigo-500 text-white px-4 py-2 rounded-md ml-2">Send</button>
            </div>
        </footer>
    @endif
</div>
