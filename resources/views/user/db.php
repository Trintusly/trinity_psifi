<body class="bg-gray-100 min-h-screen">

<main class="p-12 mx-auto max-w-7xl grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Left Section: Profile and Startup Information -->
    <aside class="col-span-1 space-y-6">
        <!-- Profile Section -->
        <section class="bg-white shadow-md p-6 rounded-lg">
            <div class="flex items-center space-x-4 mb-4">
                <img src="https://via.placeholder.com/60" alt="Profile" class="w-16 h-16 rounded-full" />
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ auth()->user()->username }}</h3>
                    <p class="text-gray-600">Welcome back!</p>
                </div>
            </div>
            <hr>
            <!-- Bio Section -->
            <form action="{{ route('user.dashboard::updateBio') }}" method="POST">
                @csrf
                <x-message />
                <div class="mt-4">
                    <label for="bio" class="block text-lg font-semibold text-gray-800">Bio</label>
                    <textarea name="bio" rows="4" class="mt-2 mb-2 w-full p-3 border border-gray-300 rounded-lg resize-none"
                        placeholder="Write something about yourself...">{{ auth()->user()->bio }}</textarea>
                </div>
                <button type="submit"
                    class="w-32 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md transition duration-300">
                    Update Bio
                </button>



            </form>
        </section>


        <!-- Manage and Create Startup -->
        <section class="space-y-4 mt-4">
            <button onclick="createStartup()"
                class="w-full bg-blue-600 text-white py-3 px-5 rounded-lg shadow-md hover:bg-blue-700">
                Create Startup
            </button>
            <button class="w-full bg-blue-600 text-white py-3 px-5 rounded-lg shadow-md hover:bg-blue-700">
                Manage Startup
            </button>

            <!-- Error Message Div (Positioned below the buttons) -->
            <div id="error-notification"
                class="hidden mt-4 bg-red-200 text-red-800 text-center py-3 px-6 rounded-lg shadow-md">
                <p id="error-message" class="font-semibold">
                    Something went wrong. Please try again later.
                </p>
            </div>
        </section>
    </aside>

    <!-- Right Section: Achievements -->
    <div class="col-span-2">
      
    </div>
</main>

</body>
