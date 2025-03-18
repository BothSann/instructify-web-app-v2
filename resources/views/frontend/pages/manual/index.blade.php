@extends('frontend.layouts.master')
@section('content')
    <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
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

        <!-- Manuals Results -->
        <div class="px-4 sm:px-0">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-4 py-4 border-b border-gray-200 sm:px-6">
                    <h1 class="text-xl font-semibold text-gray-900">
                        @if (isset($searchPerformed) && $searchPerformed)
                            Search Results for "{{ $search }}"
                        @else
                            Recently Added Manuals
                        @endif
                    </h1>

                    <!-- Search Bar -->
                    <div class="mt-3">
                        <form action="{{ route('manuals.search') }}" method="GET">
                            <div class="flex rounded-md shadow-sm">
                                <div class="relative flex-grow focus-within:z-10">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="text-gray-400 fas fa-search"></i>
                                    </div>
                                    <input type="text" name="search" id="search"
                                        class="block w-full h-10 pl-10 border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 rounded-l-md sm:text-sm"
                                        placeholder="Search manuals..." value="{{ request('search') }}" />
                                </div>
                                <button type="submit"
                                    class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-r-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span>Search</span>
                                </button>
                            </div>

                            <!-- Filters -->
                            <div class="mt-3 sm:flex sm:items-center">
                                <!-- Category Filter -->
                                <div class="mt-2 sm:mt-0 sm:mr-4">
                                    <select id="category" name="category"
                                        class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        onchange="this.form.submit()">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Sort By -->
                                <div class="mt-2 sm:mt-0">
                                    <select id="sort" name="sort"
                                        class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        onchange="this.form.submit()">
                                        <option value="relevance" {{ request('sort') == 'relevance' ? 'selected' : '' }}>
                                            Sort by: Relevance</option>
                                        <option value="newest"
                                            {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Newest
                                            First</option>
                                        <option value="alphabetical"
                                            {{ request('sort') == 'alphabetical' ? 'selected' : '' }}>A-Z</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Results List -->
                <ul class="divide-y divide-gray-200">
                    @if ($manuals->count() > 0)
                        @foreach ($manuals as $manual)
                            <li
                                class="px-4 py-4 transition-all duration-200 border border-gray-200 rounded-lg sm:px-6 hover:bg-gray-50 hover:border-indigo-400 hover:shadow-md">
                                <div class="flex items-start">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-indigo-50">
                                        <i class="text-xl text-indigo-500 fas fa-file-pdf"></i>
                                    </div>
                                    <div class="flex-1 ml-4">
                                        <div class="flex justify-between">
                                            <h3 class="text-base font-medium text-gray-900 hover:text-indigo-600">
                                                <a href="{{ route('manuals.download', $manual) }}"
                                                    class="hover:underline">{{ $manual->title }}</a>
                                            </h3>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('manuals.download', $manual) }}"
                                                    class="flex items-center justify-center w-8 h-8 text-green-600 transition-colors rounded-full hover:bg-green-50 hover:text-green-700"
                                                    title="Download">
                                                    <i class="text-lg fas fa-download"></i>
                                                </a>
                                                <a href="{{ route('complaints.create', ['manual_id' => $manual->id]) }}"
                                                    class="flex items-center justify-center w-8 h-8 transition-colors rounded-full hover:bg-amber-50 hover:text-amber-700"
                                                    title="Submit Complaint">
                                                    <i class="text-lg text-amber-500 fa-solid fa-triangle-exclamation"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ $manual->category->description }}
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500 line-clamp-2">
                                            {{ $manual->description }}
                                        </p>
                                        <div class="flex flex-wrap items-center gap-4 mt-3">
                                            <span
                                                class="px-2.5 py-1 text-xs font-medium rounded-full text-violet-700 bg-violet-100 border border-violet-200">
                                                {{ $manual->category->name }}
                                            </span>
                                            <div class="flex items-center text-xs text-gray-500">
                                                <i class="mr-2 text-amber-500 fas fa-calendar"></i>
                                                {{ $manual->created_at->format('M d, Y') }}
                                            </div>
                                            <div class="flex items-center text-xs text-gray-500">
                                                <i class="mr-2 text-rose-500 fas fa-file"></i>{{ $manual->file_size }} MB
                                            </div>
                                            <div class="flex items-center text-xs text-gray-500">
                                                <i class="mr-2 text-teal-500 fa-solid fa-user-tie"></i>
                                                @if ($manual->uploaded_by_admin)
                                                    {{ $manual->admin->name }}
                                                    <span
                                                        class="px-2 py-0.5 ml-2 text-2xs font-medium rounded text-amber-800 bg-amber-100 border border-amber-200">Admin</span>
                                                @elseif ($manual->uploaded_by)
                                                    {{ $manual->user->name }}
                                                @else
                                                    Unknown
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="px-4 py-10 text-center sm:px-6">
                            <i class="mb-4 text-4xl text-gray-400 fas fa-search"></i>
                            <h3 class="mb-1 text-lg font-medium text-gray-900">No manuals found</h3>
                            <p class="text-gray-500">Try adjusting your search term or browse all manuals</p>
                            @if (request('search') || request('category'))
                                <div class="mt-4">
                                    <a href="{{ route('manuals.index') }}"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                        View all manuals
                                    </a>
                                </div>
                            @endif
                        </li>
                    @endif
                </ul>

                <!-- Pagination -->
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
                                    Showing <span class="font-medium">{{ $manuals->count() }}</span>
                                    {{ Str::plural('result', $manuals->count()) }}
                                </p>
                            </div>

                            <!-- Pagination Controls would go here if using paginate() -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Can't Find What You're Looking For? -->
            <div class="p-6 mt-8 rounded-lg bg-indigo-50">
                <h2 class="mb-2 text-lg font-medium text-indigo-800">
                    Can't find what you're looking for?
                </h2>
                <p class="mb-4 text-indigo-600">
                    If you have the manual, you can upload it to help others.
                </p>
                <a href="{{ route('manuals.create') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Upload a Manual
                </a>
            </div>
        </div>
    </div>
@endsection
