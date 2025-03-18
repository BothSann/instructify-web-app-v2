@extends('frontend.layouts.master')
@section('content')
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
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
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h1 class="text-xl font-semibold text-gray-900">
                    My Uploaded Complaints
                </h1>
                <p class="mt-1 text-sm text-gray-600">
                    Track the status of complaints you've submitted to the system.
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
                                <option value="all" disabled selected>All Statuses</option>
                                <option value="pending">Under Review</option>
                                <option value="in-progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                        <div>
                            <label for="category-filter" class="sr-only">Filter by category</label>
                            <select id="category-filter" name="category"
                                class="block w-full py-2 pl-3 pr-10 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="all">All Categories</option>
                                <option value="1">Product Defect</option>
                                <option value="2">Service Quality</option>
                                <option value="3">Billing Issue</option>
                                <option value="4">Delivery Problem</option>
                                <option value="5">Technical Support</option>
                                <option value="6">Warranty Claim</option>
                                <option value="7">Return/Refund</option>
                                <option value="8">Customer Service</option>
                                <option value="9">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 sm:mt-0">
                        <div class="relative rounded-md shadow-sm">
                            <input type="text" name="search" id="search"
                                class="block w-full pr-10 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Search complaints..." />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="text-gray-400 fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Complaints List -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Complaint Title
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Submission Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Complaint Item 1 -->
                        @foreach ($complaints as $complaint)
                            @php
                                $statusKey = $complaint->getComplaintStatusKey();
                                $rowBgClass = match ($statusKey) {
                                    'pending' => 'bg-yellow-50',
                                    'resolved' => 'bg-green-50',
                                    'dismissed' => 'bg-red-50',
                                    default => '',
                                };

                                $badgeClasses = match ($statusKey) {
                                    'pending' => 'text-amber-800 bg-amber-100 border border-amber-200',
                                    'resolved' => 'text-green-800 bg-green-100 border border-green-200',
                                    'dismissed' => 'text-red-800 bg-red-100 border border-red-200',
                                    default => 'text-gray-800 bg-gray-100 border border-gray-200',
                                };
                            @endphp

                            <tr class="{{ $rowBgClass }} hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex items-center justify-center w-10 h-10 rounded-full 
                                        {{ $statusKey == 'pending'
                                            ? 'bg-amber-100 text-amber-600'
                                            : ($statusKey == 'resolved'
                                                ? 'bg-green-100 text-green-600'
                                                : 'bg-red-100 text-red-600') }}">
                                            <i class="text-lg fas fa-exclamation-circle"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $complaint->getComplaintTypeName() }}
                                            </div>
                                            <div class="max-w-xs text-sm text-gray-500 truncate">
                                                {{ $complaint->description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $complaint->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $badgeClasses }}">
                                        {{ $complaint->getComplaintStatusName() }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
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
                                <span class="font-medium">14</span> results
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
