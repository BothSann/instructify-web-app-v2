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

    @if (session('info'))
        <div class="px-4 py-3 mb-4 text-sm text-blue-700 bg-blue-100 rounded">
            {{ session('info') }}
        </div>
    @endif
    <!-- Manuals Management Page Content -->
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">
                Manuals Management
            </h2>
            <div class="flex space-x-2">
                <div class="relative">
                    <input type="text" placeholder="Search manuals..."
                        class="py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    <i class="absolute text-gray-400 fas fa-search left-3 top-3"></i>
                </div>
                <a href="{{ route('admin.manuals.create') }}" title="Add Manual"
                    class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <i class="mr-2 fas fa-plus"></i> Add Manual
                </a>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px">
                <li class="mr-2">
                    <a href="#"
                        class="inline-block px-4 py-2 font-medium text-indigo-600 border-b-2 border-indigo-600">
                        All Manuals ({{ $manuals->count() }})
                    </a>
                </li>
                <li class="mr-2">
                    <a href="#"
                        class="inline-block px-4 py-2 font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">
                        Approved ({{ $manuals->where('status', 'approved')->count() }})
                    </a>
                </li>
                <li class="mr-2">
                    <a href="#"
                        class="inline-block px-4 py-2 font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">
                        Pending ({{ $manuals->where('status', 'pending')->count() }})
                    </a>
                </li>
            </ul>
        </div>

        <!-- Manuals Table -->
        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="w-4 h-4 mr-3 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                                Manual
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Uploaded By
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Category
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Uploaded
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Pending Manual Row -->
                    @foreach ($manuals as $manual)
                        <tr
                            class="
                              {{ $manual->status == 'pending' ? 'text-yellow-800 bg-yellow-100' : '' }}
                              {{ $manual->status == 'approved' ? 'text-green-800 bg-green-100' : '' }}
                              {{ $manual->status == 'rejected' ? 'text-red-800 bg-red-100' : '' }}
                              ">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <input type="checkbox"
                                        class="w-4 h-4 mr-3 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-blue-100 rounded">
                                        <i class="text-blue-500 fas fa-file-pdf"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $manual->title }}
                                        </div>
                                        <div class="max-w-md mt-1 text-xs text-gray-500 truncate">
                                            {{ $manual->description }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if ($manual->uploaded_by_admin)
                                        {{ $manual->admin->name }} <span
                                            class="text-xs font-medium bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Admin</span>
                                    @elseif ($manual->uploaded_by)
                                        {{ $manual->user->name }}
                                    @else
                                        <span class="text-gray-500">Unknown</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">
                                    @if ($manual->uploaded_by_admin)
                                        {{ $manual->admin->email }}
                                    @elseif ($manual->uploaded_by)
                                        {{ $manual->user->email }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full ">
                                    {{ $manual->category->name }}
                                </span>
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
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $manual->created_at->format('M d, Y') }}
                            </td>
                            <!-- OR for Option 2: Single form with different buttons -->
                            <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <!-- Downlaod button -->
                                    <a href="{{ route('admin.manuals.download', $manual) }}"
                                        class="text-indigo-600 hover:text-indigo-900" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <!-- Approve button -->
                                    <form action="{{ route('admin.manuals.approve', $manual->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <!-- Reject button -->
                                    <form action="{{ route('admin.manuals.reject', $manual->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    <!-- Reject button -->
                                    <form action="{{ route('admin.manuals.destroy', $manual->id) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this manual? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-900"
                                            title="Delete Manual">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

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
                                <span class="font-medium">{{ $manual->count() }}</span> of
                                <span class="font-medium">{{ $manual->count() }}</span> manuals
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm"
                                aria-label="Pagination">
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
                                <span
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">
                                    ...
                                </span>
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50">
                                    25
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
            </div>
        </div>
    </div>
@endsection
