@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div style="font-size: 12px; position: fixed; top: 10; right: 0;">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible  fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <script>
                setTimeout(function () {
                    document.querySelectorAll('.alert').forEach(alert => {
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                    });
                }, 11000);
            </script>
        </div>


        <!-- Header with navigation -->
        <header class="bg-white shadow rounded-lg mb-6">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center space-x-4">
                    <div class="text-xl font-bold text-indigo-600">ChatApp</div>
                    <nav class="hidden md:flex space-x-6">
                        <a href="#" class="text-gray-500 hover:text-indigo-600">Home</a>
                        <a href="#" class="text-indigo-600 font-medium">Profile</a>
                        <a href="{{ route('chat') }}" class="text-gray-500 hover:text-indigo-600">Messages</a>
                        <a href="#" class="text-gray-500 hover:text-indigo-600">Settings</a>
                    </nav>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-indigo-600">
                        <i class="fas fa-bell"></i>
                    </button>
                    <div class="h-8 w-px bg-gray-200"></div>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200">
                            <img id="nav-profile-pic" src="{{ asset('storage/' . $user->imagePath) }}" alt="Profile"
                                class="w-full h-full object-cover">
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ $user->name }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left sidebar with profile summary -->
            <div class="md:col-span-1">
                <div class="bg-white shadow rounded-lg p-6">
                    <!-- Profile picture section -->
                    <div class="flex flex-col items-center">
                        <div class="relative w-32 h-32 mb-4 profile-picture-container">
                            <div class="w-full h-full rounded-full overflow-hidden bg-gray-200">
                                <img id="main-profile-pic" src="{{ asset('storage/' . $user->imagePath) }}" alt="Profile"
                                    class="w-full h-full object-cover">
                            </div>
                            <form action="{{ route('profile.picture') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-40 rounded-full flex items-center justify-center opacity-0 transition-opacity duration-300 profile-picture-overlay">
                                    <label for="profile-upload" class="cursor-pointer text-white p-2">
                                        <i class="fas fa-camera"></i>
                                        <span class="ml-2">Change</span>
                                    </label>
                                    <input type="file" name="profile" id="profile-upload" class="hidden" accept="image/*">
                                </div>
                                <button type="submit">Save image</button>
                            </form>

                        </div>
                        <h2 id="profile-name" class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-indigo-600 text-sm font-medium">{{ $user->username }}</p>
                        <div class="mt-4 flex items-center text-gray-600">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="ml-2 text-sm">San Francisco, CA</span>
                        </div>
                    </div>

                    <!-- Stats section -->
                    <div class="mt-6 grid grid-cols-3 gap-4 border-t border-gray-200 pt-6">
                        <div class="text-center">
                            <span class="block text-lg font-bold text-gray-800">245</span>
                            <span class="text-xs text-gray-500">Messages</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-lg font-bold text-gray-800">43</span>
                            <span class="text-xs text-gray-500">Groups</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-lg font-bold text-gray-800">128</span>
                            <span class="text-xs text-gray-500">Contacts</span>
                        </div>
                    </div>

                    <!-- Quick actions -->
                    <div class="mt-6 space-y-3">
                        <button
                            class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-200">
                            Edit Profile
                        </button>
                        <button
                            class="w-full py-2 px-4 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition duration-200">
                            Share Profile
                        </button>
                    </div>
                </div>

                <!-- Contact information -->
                <div class="bg-white shadow rounded-lg p-6 mt-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Contact Information</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 text-indigo-500 mt-1">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-800">{{ $user->email }}</p>
                                <p class="text-xs text-gray-500">Email</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 text-indigo-500 mt-1">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-800">+1 (555) 123-4567</p>
                                <p class="text-xs text-gray-500">Phone</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 text-indigo-500 mt-1">
                                <i class="fas fa-globe"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-800">johndoe.com</p>
                                <p class="text-xs text-gray-500">Website</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main profile content -->
            <div class="md:col-span-2">
                <!-- Profile options tabs -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="px-4 sm:px-6 border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <a href="#"
                                class="py-4 px-1 border-b-2 border-indigo-500 text-indigo-600 font-medium text-sm flex-1 text-center">
                                About
                            </a>
                            <a href="#"
                                class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm flex-1 text-center">
                                Privacy
                            </a>
                            <a href="#"
                                class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm flex-1 text-center">
                                Notifications
                            </a>
                            <a href="#"
                                class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm flex-1 text-center">
                                Security
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Profile form -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-6">Personal Information</h3>
                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Name</label>
                                <input type="text" id="first-name" name="first-name" value="{{ $user->name }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2 border">
                            </div>
                            <div>
                                <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">
                                    username</label>
                                <input type="text" id="last-name" name="last-name" value="{{ $user->username }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2 border">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                    Address</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2 border">
                            </div>
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                <input type="text" id="username" name="username" value="{{ $user->username }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2 border">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="+1 (555) 123-4567"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2 border">
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <input type="text" id="location" name="location" value="San Francisco, CA"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2 border">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                            <textarea id="bio" name="bio" rows="4"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2 border">Hi, I'm John! I'm a software developer based in San Francisco. I love coding, hiking, and photography.</textarea>
                        </div>

                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-800 mb-3">Profile Visibility</h4>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="radio" id="public" name="visibility"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" checked>
                                    <label for="public" class="ml-3">
                                        <span class="block text-sm font-medium text-gray-700">Public</span>
                                        <span class="block text-sm text-gray-500">Anyone can see your profile</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="contacts-only" name="visibility"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                    <label for="contacts-only" class="ml-3">
                                        <span class="block text-sm font-medium text-gray-700">Contacts Only</span>
                                        <span class="block text-sm text-gray-500">Only your contacts can see your
                                            profile</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="private" name="visibility"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                    <label for="private" class="ml-3">
                                        <span class="block text-sm font-medium text-gray-700">Private</span>
                                        <span class="block text-sm text-gray-500">Only you can see your profile</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <button type="button"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Additional Settings -->
                <div class="bg-white shadow rounded-lg p-6 mt-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-6">Profile Preferences</h3>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-800">Show Online Status</h4>
                                <p class="text-sm text-gray-500">Allow others to see when you're online</p>
                            </div>
                            <label class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" class="sr-only" checked>
                                    <div class="block bg-gray-200 w-10 h-6 rounded-full"></div>
                                    <div
                                        class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition transform translate-x-4">
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-800">Message Receipts</h4>
                                <p class="text-sm text-gray-500">Send read receipts when you read messages</p>
                            </div>
                            <label class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" class="sr-only" checked>
                                    <div class="block bg-gray-200 w-10 h-6 rounded-full"></div>
                                    <div
                                        class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition transform translate-x-4">
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-800">Message Preview</h4>
                                <p class="text-sm text-gray-500">Show message previews in notifications</p>
                            </div>
                            <label class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" class="sr-only">
                                    <div class="block bg-gray-200 w-10 h-6 rounded-full"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-800">Sound Notifications</h4>
                                <p class="text-sm text-gray-500">Play sounds for new messages</p>
                            </div>
                            <label class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" class="sr-only" checked>
                                    <div class="block bg-gray-200 w-10 h-6 rounded-full"></div>
                                    <div
                                        class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition transform translate-x-4">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle profile picture upload
        document.getElementById('profile-upload').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    // Update both profile pictures with the new image
                    document.getElementById('main-profile-pic').src = e.target.result;
                    document.getElementById('nav-profile-pic').src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        });

        // Handle form inputs to update profile name
        document.getElementById('first-name').addEventListener('input', updateProfileName);
        document.getElementById('last-name').addEventListener('input', updateProfileName);

        function updateProfileName() {
            const firstName = document.getElementById('first-name').value;
            const lastName = document.getElementById('last-name').value;
            document.getElementById('profile-name').textContent = `${firstName} ${lastName}`;
        }

        // Toggle switches animation
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const dot = this.parentElement.querySelector('.dot');
                if (this.checked) {
                    dot.classList.add('translate-x-4');
                } else {
                    dot.classList.remove('translate-x-4');
                }
            });
        });
    </script>
@endsection
