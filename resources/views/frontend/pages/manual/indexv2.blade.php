@extends('frontend.layouts.master')
@section('content')
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white rounded-lg shadow">
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
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h1 class="text-xl font-semibold text-gray-900">
                    My Uploaded Manuals
                </h1>
                <p class="mt-1 text-sm text-gray-600">
                    Track the status of manuals you've uploaded to the library.
                </p>
            </div>

            <!-- Filter options -->
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="flex space-x-4">
                        <div>
                            <label for="status-filter" class="sr-only">Filter by status</label>
                            <select id="status-filter" name="status"
                                class="block w-full py-2 pl-3 pr-10 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="all">All Statuses</option>
                                <option value="pending">Pending Review</option>
                                <option value="approved">Approved</option>
                                <option value="denied">Denied</option>
                            </select>
                        </div>
                        <div>
                            <label for="category-filter" class="sr-only">Filter by category</label>
                            <select id="category-filter" name="category"
                                class="block w-full py-2 pl-3 pr-10 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="all">All Categories</option>
                                <option value="1">Home Appliances</option>
                                <option value="2">Electronics</option>
                                <option value="3">Computer & Accessories</option>
                                <option value="4">Kitchen Appliances</option>
                                <option value="5">Tools & Hardware</option>
                                <option value="6">Automotive</option>
                                <option value="7">Audio & Home Entertainment</option>
                                <option value="8">Mobile Phones & Tablets</option>
                                <option value="9">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 sm:mt-0">
                        <div class="relative rounded-md shadow-sm">
                            <input type="text" name="search" id="search"
                                class="block w-full pr-10 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Search uploads..." />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="text-gray-400 fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manuals List -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Manual Title
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Category
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Upload Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Manual Item 1 -->
                        @foreach ($manuals as $manual)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-md bg-violet-100">
                                            <i class="text-violet-500 fas fa-file-pdf"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $manual->title }}
                                            </div>
                                            <div class="max-w-xs text-sm text-gray-500 truncate">
                                                {{ $manual->description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $manual->category->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $manual->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                            {{ $manual->status == 'pending' ? 'text-yellow-800 bg-yellow-200' : '' }}
                                            {{ $manual->status == 'approved' ? 'text-green-800 bg-green-200' : '' }}
                                            {{ $manual->status == 'rejected' ? 'text-red-800 bg-red-200' : '' }}
                                        ">
                                        {{ $statuses[$manual->status] ?? 'Unknown' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        {{-- <!-- Manual Item 2 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-gray-100 rounded-md">
                                        <i class="text-gray-500 fas fa-file-pdf"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Sony Bravia 55X80J 4K TV
                                        </div>
                                        <div class="max-w-xs text-sm text-gray-500 truncate">
                                            Complete user guide and setup instructions
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Electronics</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Mar 5, 2023</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full">
                                    Pending Review
                                </span>
                            </td>
                        </tr>

                        <!-- Manual Item 3 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-gray-100 rounded-md">
                                        <i class="text-gray-500 fas fa-file-pdf"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Bosch Dishwasher SHX87PW55N
                                        </div>
                                        <div class="max-w-xs text-sm text-gray-500 truncate">
                                            Installation and operation guide
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    Kitchen Appliances
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Feb 28, 2023</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                    Denied
                                </span>
                            </td>
                        </tr>

                        <!-- Manual Item 4 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-gray-100 rounded-md">
                                        <i class="text-gray-500 fas fa-file-pdf"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Dell XPS 15 9510 Laptop
                                        </div>
                                        <div class="max-w-xs text-sm text-gray-500 truncate">
                                            User manual and troubleshooting guide
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    Computer & Accessories
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Feb 22, 2023</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                    Approved
                                </span>
                            </td>
                        </tr>

                        <!-- Manual Item 5 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-gray-100 rounded-md">
                                        <i class="text-gray-500 fas fa-file-pdf"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            DeWalt DCD777 Drill
                                        </div>
                                        <div class="max-w-xs text-sm text-gray-500 truncate">
                                            Operation manual and safety information
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Tools & Hardware</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Feb 15, 2023</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full">
                                    Pending Review
                                </span>
                            </td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>

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
                                Showing <span class="font-medium">1</span> to
                                <span class="font-medium">5</span> of
                                <span class="font-medium">12</span> results
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                <a href="#"
                                    class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <i class="w-5 h-5 fas fa-chevron-left"></i>
                                </a>
                                <a href="#" aria-current="page"
                                    class="relative z-10 inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 border border-indigo-500 bg-indigo-50">
                                    1
                                </a>
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50">
                                    2
                                </a>
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50">
                                    3
                                </a>
                                <a href="#"
                                    class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <i class="w-5 h-5 fas fa-chevron-right"></i>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
