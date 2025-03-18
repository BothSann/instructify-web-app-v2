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
    <!-- Complaints Management Page Content -->
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">
                Complaints Management
            </h2>
            <div class="relative">
                <form action="{{ route('admin.complaints.index') }}" method="GET">
                    @if (request()->has('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif
                    <div class="flex items-center">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search complaints..."
                            class="py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                        <i class="absolute text-gray-400 fas fa-search left-3 top-3"></i>
                        <button type="submit"
                            class="px-4 py-2 ml-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            Search
                        </button>
                        @if (request()->has('search') || request()->has('filter'))
                            <a href="{{ route('admin.complaints.index') }}"
                                class="px-4 py-2 ml-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px">
                <li class="mr-2">
                    <a href="{{ route('admin.complaints.index') }}"
                        class="inline-block px-4 py-2 font-medium {{ !request('filter') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        All Complaints ({{ $allCount }})
                    </a>
                </li>
                <li class="mr-2">
                    <a href="{{ route('admin.complaints.index', ['filter' => 'pending', 'search' => request('search')]) }}"
                        class="inline-block px-4 py-2 font-medium {{ request('filter') === 'pending' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        Pending ({{ $pendingCount }})
                    </a>
                </li>
                <li class="mr-2">
                    <a href="{{ route('admin.complaints.index', ['filter' => 'resolved', 'search' => request('search')]) }}"
                        class="inline-block px-4 py-2 font-medium {{ request('filter') === 'resolved' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        Resolved ({{ $resolvedCount }})
                    </a>
                </li>
                <li class="mr-2">
                    <a href="{{ route('admin.complaints.index', ['filter' => 'dismissed', 'search' => request('search')]) }}"
                        class="inline-block px-4 py-2 font-medium {{ request('filter') === 'dismissed' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        Dismissed ({{ $dismissedCount }})
                    </a>
                </li>
            </ul>
        </div>

        <!-- Complaints Cards -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            @if ($complaints->count() > 0)
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
                                        <span
                                            class="px-2 py-1 mr-2 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
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
                                    <p class="text-sm text-gray-600">Date: {{ $complaint->created_at->format('M d, Y') }}
                                    </p>
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
                                        <form action="{{ route('admin.complaints.resolve', $complaint->id) }}"
                                            method="POST">
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
                                        <form action="{{ route('admin.complaints.dismiss', $complaint->id) }}"
                                            method="POST">
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
            @else
                <div class="col-span-2 p-6 text-center bg-white rounded-lg shadow-md">
                    <p class="text-gray-600">No complaints found matching your criteria.</p>
                </div>
            @endif
        </div>

        <!-- Pagination (if needed) -->
        @if ($complaints->count() > 0)
            <div class="flex items-center justify-between mt-6">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $complaints->count() }}</span> complaints
                    </p>
                </div>
            </div>
        @endif
    </div>
@endsection
