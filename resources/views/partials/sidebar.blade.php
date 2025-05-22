<!-- Sidebar -->
<div id="Sidebar" class="w-1/4 bg-white border-r border-gray-300">
    <!-- Sidebar Header -->
    <header class="p-4 border-b border-gray-300 flex justify-between items-center bg-indigo-600 text-white">
        <h1 class="text-2xl font-semibold">Chat Web</h1>
    </header>

    <!-- Contact List -->
    <div id="newMessageNotification" class="overflow-y-auto h-screen p-3 mb-9 pb-20">
        @if ($users->count() > 1)
            @foreach ($users as $user)
                <a href="{{ route('chat.with', $user->id) }}">
                    <div class="flex items-center mb-4 cursor-pointer hover:bg-gray-100 p-2 rounded-md"
                        data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                        <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
                            <img src="{{ asset('storage/' . $user->imagePath) }}" alt="User Avatar"
                                class="w-12 h-12 rounded-full">
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
                            @if($user->last_message)
                                <div class="flex">
                                    <p class="text-gray-600"> {{ $user->last_message->message }}</p>
                                    <span class="pt-3" style="font-size: 10px">
                                        {{ $user->last_message->created_at->diffForHumans() }}

                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        @else

        @endif
    </div>
</div>
