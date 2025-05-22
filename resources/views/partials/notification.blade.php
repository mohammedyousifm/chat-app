<div class="relative z-50">

    <!-- Bell Icon -->
    <button id="showNotification" class="relative p-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span id="notificationIconCount" class="absolute top-0 right-0 bg-red-500 text-white text-xs px-1 rounded-full">
            {{ count(auth()->user()->unreadNotifications) }}
        </span>
    </button>

    <!-- Sidebar -->
    <div id="NotificationSidebar" style="will-change: transform;">

        <!-- Header -->
        <div class="flex items-center  bg-indigo-600 justify-between p-4 border-b">
            <h2 class="text-lg text-white font-semibold">Notifications</h2>
            <i id="NotificationSidebarIcon" class="fa-solid text-white fa-x"></i>
        </div>

        <!-- Notification List -->
        <div class="p-4 space-y-3" id="notificationIconModel">
            @forelse(auth()->user()->notifications->take(5) as $notification)
                <div class="border p-3 rounded bg-gray-50">
                    <p class="text-sm font-semibold">New message!</p>
                    <p class="text-sm text-gray-600">{{ $notification->data['message'] }}</p>
                    <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-center text-sm text-gray-500">No notifications yet.</p>
            @endforelse
        </div>

        <!-- Footer -->
        <div class="p-4 border-t">
            <button id="clearNotification"
                class="w-full bg-gray-100 bg-indigo-600 text-white hover:bg-ndigo-400 py-2 rounded text-sm text-gray-700">
                Clear All
            </button>
        </div>
    </div>
</div>
