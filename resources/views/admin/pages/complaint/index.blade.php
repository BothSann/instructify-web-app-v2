@extends ('admin.layouts.master')
@section('content')
    {{-- {{ dd($complaint->getStatusName()) }} --}}
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
    <!-- Complaints Management Page Content -->
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">
                Complaints Management
            </h2>
            <div class="relative">
                <input type="text" placeholder="Search complaints..."
                    class="py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                <i class="absolute text-gray-400 fas fa-search left-3 top-3"></i>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px">
                <li class="mr-2">
                    <a href="#"
                        class="inline-block px-4 py-2 font-medium text-indigo-600 border-b-2 border-indigo-600">
                        All Complaints ({{ $complaints->count() }})
                    </a>
                </li>
                <li class="mr-2">
                    <a href="#"
                        class="inline-block px-4 py-2 font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">
                        Resolved ({{ $complaints->where('status', 'resolved')->count() }})
                    </a>
                </li>
                <li class="mr-2">
                    <a href="#"
                        class="inline-block px-4 py-2 font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">
                        Dismissed ({{ $complaints->where('status', 'dismissed')->count() }})
                    </a>
                </li>
            </ul>
        </div>

        <!-- Complaints Cards -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Complaint Card 1 -->
            @foreach ($complaints as $complaint)
                <div
                    class="overflow-hidden bg-white rounded-lg shadow-md
                      {{ $complaint->getComplaintStatusKey() == 'pending'
                          ? 'border-l-4 border-yellow-500'
                          : ($complaint->getComplaintStatusKey() == 'resolved'
                              ? 'border-l-4 border-green-500'
                              : ($complaint->getComplaintStatusKey() == 'dismissed'
                                  ? 'border-l-4 border-red-500'
                                  : '')) }}
                ">
                    <div class="p-5 border-b border-gray-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center">
                                    <span class="px-2 py-1 mr-2 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
                                        {{ $complaint->getComplaintTypeName() }}
                                    </span>
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $complaint->getComplaintStatusKey() == 'pending'
                                            ? 'text-yellow-800 bg-yellow-100'
                                            : ($complaint->getComplaintStatusKey() == 'resolved'
                                                ? 'text-green-800 bg-green-100'
                                                : ($complaint->getComplaintStatusKey() == 'dismissed'
                                                    ? 'text-red-800 bg-red-100'
                                                    : '')) }}
                                      ">
                                        {{ $complaint->getComplaintStatusName() }}
                                    </span>
                                </div>
                                <h3 class="mt-2 text-lg font-semibold text-gray-900">
                                    {{ $complaint->manual->title }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Reported by: {{ $complaint->user->name }} ({{ $complaint->user->email }})
                                </p>
                                <p class="text-sm text-gray-600">Date: {{ $complaint->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="text-indigo-600 hover:text-indigo-900" title="Download Manual">
                                    <a href="{{ route('admin.manuals.download', $complaint->manual) }}">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 bg-gray-50">
                        <p class="mb-1 text-sm font-medium text-gray-700">
                            Complaint Description:
                        </p>
                        <p class="mb-4 text-sm text-gray-600">
                            {{ $complaint->description }}
                        </p>

                        @if ($complaint->getComplaintStatusKey() == 'resolved')
                            <div class="flex items-center mb-3 text-sm text-green-600">
                                <i class="mr-2 fas fa-check-circle"></i>
                                <span>Resolved by Admin ({{ $admin->name }}) on
                                    {{ $complaint->updated_at->format('M d, Y') }}
                                </span>
                            </div>
                        @endif

                        <div class="flex justify-between">
                            <div class="flex space-x-2">
                                @if ($complaint->getComplaintStatusKey() == 'resolved')
                                    {{-- Show non-clickable "Resolved" indicator --}}
                                    <div class="px-3 py-1 text-xs text-white bg-green-600 rounded-md">
                                        Resolved
                                    </div>
                                @else
                                    {{-- Show "Mark as Resolved" button for open complaints --}}
                                    <form action="{{ route('admin.complaints.resolve', $complaint->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 text-xs text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            Mark as Resolved
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div>
                                @if ($complaint->getComplaintStatusKey() == 'dismissed')
                                    {{-- Show non-clickable "Dismissed" indicator --}}
                                    <div class="px-3 py-1 text-xs text-white bg-red-600 rounded-md">
                                        Dismissed
                                    </div>
                                @elseif ($complaint->getComplaintStatusKey() != 'resolved')
                                    {{-- Show "Dismiss Complaint" button only for non-resolved complaints --}}
                                    <form action="{{ route('admin.complaints.dismiss', $complaint->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 text-xs text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                            Dismiss Complaint
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


            <!-- Complaint Card 2 -->
            {{-- <div class="overflow-hidden bg-white rounded-lg shadow-md">
                <div class="p-5 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 mr-2 text-xs font-semibold text-orange-800 bg-orange-100 rounded-full">
                                    Missing Content
                                </span>
                                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
                                    Open
                                </span>
                            </div>
                            <h3 class="mt-2 text-lg font-semibold text-gray-900">
                                LG Washing Machine WM3700HVA
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Reported by: Jane Smith (jane.smith@example.com)
                            </p>
                            <p class="text-sm text-gray-600">Date: Mar 10, 2023</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="text-indigo-600 hover:text-indigo-900" title="View Manual">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                            <button class="text-gray-600 hover:text-gray-900" title="View User Profile">
                                <i class="fas fa-user"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-5 bg-gray-50">
                    <p class="mb-1 text-sm font-medium text-gray-700">
                        Complaint Description:
                    </p>
                    <p class="mb-4 text-sm text-gray-600">
                        The troubleshooting section is missing information about error
                        code "LE". I'm experiencing this error and need to know how to
                        fix it. Please update the manual with this information.
                    </p>
                    <div class="flex justify-between">
                        <div class="flex space-x-2">
                            <button
                                class="px-3 py-1 text-xs text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Mark as Resolved
                            </button>
                            <button
                                class="px-3 py-1 text-xs text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Contact User
                            </button>
                        </div>
                        <button
                            class="px-3 py-1 text-xs text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Delete Complaint
                        </button>
                    </div>
                </div>
            </div>

            <!-- Complaint Card 3 (Resolved) -->
            <div class="overflow-hidden bg-white border-l-4 border-green-500 rounded-lg shadow-md">
                <div class="p-5 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center">
                                <span class="px-2 py-1 mr-2 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                                    Poor Quality
                                </span>
                                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                    Resolved
                                </span>
                            </div>
                            <h3 class="mt-2 text-lg font-semibold text-gray-900">
                                Sony Bravia KD-55X80J Television
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Reported by: Michael Brown (michael.b@example.com)
                            </p>
                            <p class="text-sm text-gray-600">Date: Mar 5, 2023</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="text-indigo-600 hover:text-indigo-900" title="View Manual">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                            <button class="text-gray-600 hover:text-gray-900" title="View User Profile">
                                <i class="fas fa-user"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-5 bg-gray-50">
                    <p class="mb-1 text-sm font-medium text-gray-700">
                        Complaint Description:
                    </p>
                    <p class="mb-4 text-sm text-gray-600">
                        The images in the manual are very low resolution and it's hard
                        to see the button labels. Could you please upload a higher
                        quality version of this manual?
                    </p>
                    <div class="flex items-center mb-3 text-sm text-green-600">
                        <i class="mr-2 fas fa-check-circle"></i>
                        <span>Resolved by Admin (David Wilson) on Mar 8, 2023</span>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex space-x-2">
                            <button
                                class="px-3 py-1 text-xs text-white bg-yellow-600 rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                Reopen
                            </button>
                        </div>
                        <button
                            class="px-3 py-1 text-xs text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Delete Complaint
                        </button>
                    </div>
                </div>
            </div>

            <!-- Complaint Card 4 -->
            <div class="overflow-hidden bg-white rounded-lg shadow-md">
                <div class="p-5 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 mr-2 text-xs font-semibold text-purple-800 bg-purple-100 rounded-full">
                                    Copyright Issue
                                </span>
                                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
                                    Open
                                </span>
                            </div>
                            <h3 class="mt-2 text-lg font-semibold text-gray-900">
                                Dyson V11 Vacuum Cleaner
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Reported by: Sarah Johnson (sarah.j@example.com)
                            </p>
                            <p class="text-sm text-gray-600">Date: Mar 14, 2023</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="text-indigo-600 hover:text-indigo-900" title="View Manual">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                            <button class="text-gray-600 hover:text-gray-900" title="View User Profile">
                                <i class="fas fa-user"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-5 bg-gray-50">
                    <p class="mb-1 text-sm font-medium text-gray-700">
                        Complaint Description:
                    </p>
                    <p class="mb-4 text-sm text-gray-600">
                        I believe this manual was uploaded without permission from
                        Dyson. This appears to be copyrighted material that should not
                        be freely distributed. Please review and remove if
                        appropriate.
                    </p>
                    <div class="flex justify-between">
                        <div class="flex space-x-2">
                            <button
                                class="px-3 py-1 text-xs text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Mark as Resolved
                            </button>
                            <button
                                class="px-3 py-1 text-xs text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Contact User
                            </button>
                        </div>
                        <button
                            class="px-3 py-1 text-xs text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Delete Complaint
                        </button>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-6">
            <div>
                <p class="text-sm text-gray-700">
                    Showing <span class="font-medium">1</span> to
                    <span class="font-medium">4</span> of
                    <span class="font-medium"></span> complaints
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a href="#"
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">
                        <span class="sr-only">Previous</span>
                        <i class="fas fa-chevron-left"></i>
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
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50">
                        4
                    </a>
                    <a href="#"
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">
                        <span class="sr-only">Next</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
@endsection
