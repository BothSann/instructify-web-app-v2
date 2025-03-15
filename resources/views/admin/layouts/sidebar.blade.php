<div class="hidden px-8 py-6 text-white bg-indigo-800 w-80 md:block">
    <div class="flex items-center justify-center mt-2 mb-8">
        <i class="mr-2 text-2xl fas fa-book-open"></i>
        <h1 class="text-xl font-bold">Instructify Manager</h1>
    </div>
    <nav>
        <a href="#" class="flex items-center px-4 py-3 mb-2 bg-indigo-900 rounded-lg">
            <i class="mr-3 fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="#" class="flex items-center px-4 py-3 mb-2 rounded-lg hover:bg-indigo-700">
            <i class="mr-3 fas fa-book"></i>
            <span>Manuals</span>
        </a>
        <a href="#" class="flex items-center px-4 py-3 mb-2 rounded-lg hover:bg-indigo-700">
            <i class="mr-3 fas fa-users"></i>
            <span>Users</span>
        </a>
        <a href="#" class="flex items-center px-4 py-3 mb-2 rounded-lg hover:bg-indigo-700">
            <i class="mr-3 fas fa-flag"></i>
            <span>Complaints</span>
        </a>

        <div class="my-4 border-t border-indigo-700 rounded-lg hover:bg-indigo-700">
            <form action="" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 mb-2">
                    <i class="mr-3 fas fa-cog"></i>
                    <span>Settings</span>
                </button>
            </form>
        </div>

        <div>
            <form class="my-4 border-t border-indigo-700 rounded-lg hover:bg-indigo-700"
                action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3">
                    <i class="mr-3 fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

    </nav>
</div>
