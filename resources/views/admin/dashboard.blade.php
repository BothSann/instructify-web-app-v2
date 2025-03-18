@extends ('admin.layouts.master')
@section('content')
    <div class="p-6">
        <h2 class="mb-6 text-2xl font-semibold text-gray-800">
            Dashboard Overview
        </h2>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 lg:grid-cols-4">
            {{-- Total Users --}}
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 mr-4 bg-blue-100 rounded-full">
                        <i class="text-xl text-blue-500 fas fa-user-friends"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Users</p>
                        <p class="text-2xl font-semibold">{{ $usersCount }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Manuals --}}
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 mr-4 bg-green-100 rounded-full">
                        <i class="text-xl text-green-500 fas fa-book-open"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Manuals</p>
                        <p class="text-2xl font-semibold">{{ $manualsCount }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Pending Approvals (Manuals) --}}
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 mr-4 bg-yellow-100 rounded-full">
                        <i class="text-xl text-yellow-500 fas fa-hourglass-half"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pending Manuals</p>
                        <p class="text-2xl font-semibold">{{ $pendingApprovals }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Approved Manuals --}}
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 mr-4 bg-green-100 rounded-full">
                        <i class="text-xl text-green-500 fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Approved Manuals</p>
                        <p class="text-2xl font-semibold">{{ $approvedManuals }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Rejected Manuals --}}
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 mr-4 bg-red-100 rounded-full">
                        <i class="text-xl text-red-500 fas fa-times-circle"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Rejected Manuals</p>
                        <p class="text-2xl font-semibold">{{ $rejectedManuals }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Resolved Complaints --}}
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 mr-4 bg-blue-100 rounded-full">
                        <i class="text-xl text-blue-500 fas fa-check"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Resolved Complaints</p>
                        <p class="text-2xl font-semibold">{{ $resolvedComplaints }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Pending Review Complaints --}}
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 mr-4 bg-yellow-100 rounded-full">
                        <i class="text-xl text-yellow-500 fas fa-pause-circle"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pending Complaints</p>
                        <p class="text-2xl font-semibold">{{ $pendingComplaints }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Dismissed Complaints --}}
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 mr-4 bg-red-100 rounded-full">
                        <i class="text-xl text-red-500 fas fa-ban"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Dismissed Complaints</p>
                        <p class="text-2xl font-semibold">{{ $dismissedComplaints }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
