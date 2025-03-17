@extends ('admin.layouts.master')
@section('content')
    <div class="p-6">
        <h2 class="mb-6 text-2xl font-semibold text-gray-800">
            Dashboard Overview
        </h2>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 mr-4 bg-blue-100 rounded-full">
                        <i class="text-xl text-blue-500 fas fa-book"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Manuals</p>
                        <p class="text-2xl font-semibold">{{ $manualsCount }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 mr-4 bg-green-100 rounded-full">
                        <i class="text-xl text-green-500 fas fa-users"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 texxt-sm">Total Users</p>
                        <p class="text-2xl font-semibold">{{ $usersCount }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 mr-4 bg-yellow-100 rounded-full">
                        <i class="text-xl text-yellow-500 fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pending Approvals</p>
                        <p class="text-2xl font-semibold">{{ $pendingApprovals }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 mr-4 bg-red-100 rounded-full">
                        <i class="text-xl text-red-500 fas fa-flag"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Resolved Complaints</p>
                        <p class="text-2xl font-semibold">{{ $resolvedComplaints }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
