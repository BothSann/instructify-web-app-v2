<!-- Top Navigation -->
<header class="flex items-center justify-end p-4 bg-white shadow-md">
    <button class="text-gray-700 md:hidden">
        <i class="text-xl fas fa-bars"></i>
    </button>
    <div class="flex items-center gap-4 mr-6">
        <span class="text-gray-700 ">{{ Auth::user()->name }}</span>
        <div class="flex items-center justify-center w-10 h-10 bg-indigo-200 rounded-full">
            <i class="text-indigo-600 fas fa-user"></i>
        </div>
    </div>
</header>
