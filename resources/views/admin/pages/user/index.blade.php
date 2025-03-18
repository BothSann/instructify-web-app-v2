@extends ('admin.layouts.master')
@section('content')
    @if (session('success'))
        <div class="px-4 py-3 mb-4 text-sm text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="px-4 py-3 mb-4 text-sm text-red-700 bg-red-100 rounded">
            {{ session('error') }}
        </div>
    @endif
    <!-- Users Management Page Content -->
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">
                Users Management
            </h2>
            <div class="flex space-x-2">
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}"
                            class="py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                        <i class="absolute text-gray-400 fas fa-search left-3 top-3"></i>
                    </div>
                    <button type="submit"
                        class="px-3 py-2 ml-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Search
                    </button>
                    @if (request('search'))
                        <a href="{{ route('admin.users.index', request()->except('search')) }}"
                            class="px-3 py-2 ml-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Clear
                        </a>
                    @endif
                </form>
                <a href="{{ route('admin.users.create') }}" title="Add User"
                    class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <i class="mr-2 fas fa-plus"></i> Add User
                </a>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px">
                <li class="mr-2">
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-block px-4 py-2 font-medium {{ !request()->has('filter') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        All Users ({{ $totalUsers }})
                    </a>
                </li>
                <li class="mr-2">
                    <a href="{{ route('admin.users.index', ['filter' => 'active']) }}"
                        class="inline-block px-4 py-2 font-medium {{ request('filter') == 'active' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        Active ({{ $activeUsers }})
                    </a>
                </li>
                <li class="mr-2">
                    <a href="{{ route('admin.users.index', ['filter' => 'banned']) }}"
                        class="inline-block px-4 py-2 font-medium {{ request('filter') == 'banned' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        Banned ({{ $bannedUsers }})
                    </a>
                </li>
            </ul>
        </div>

        <!-- Users Table -->
        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="w-4 h-4 mr-3 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                                User
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Email
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Uploads
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Joined
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if ($users->count() > 0)
                        @foreach ($users as $user)
                            <tr class="{{ $user->is_banned == 1 ? 'bg-red-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                            class="w-4 h-4 mr-3 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                                        <div
                                            class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-gray-200 rounded-full">
                                            <i class="text-gray-500 fas fa-user"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">
                                        {{ $user->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->manuals->count() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $user->is_banned == 1 ? 'text-red-800 bg-red-100' : 'text-green-800 bg-green-100' }} ">
                                        {{ $user->is_banned == 1 ? 'Banned' : 'Active' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                    <div class="flex gap-2">
                                        @if (!$user->is_banned)
                                            <form action="{{ route('admin.users.ban', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" title="Ban User"
                                                    class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.users.unban', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" title="Unban User"
                                                    class="text-green-600 hover:text-green-900">
                                                    <i class="fa-solid fa-lock-open"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete User"
                                                class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Pagination (keep the existing pagination code) -->
            <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="flex justify-between flex-1 sm:hidden">
                        <a href="#"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Previous
                        </a>
                        <a href="#"
                            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Next
                        </a>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ $users->count() > 0 ? '1' : '0' }}</span> to
                                <span class="font-medium">{{ $users->count() }}</span> of
                                <span class="font-medium">{{ $totalUsers }}</span> users
                            </p>
                        </div>
                        <!-- Add pagination controls if you implement pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
