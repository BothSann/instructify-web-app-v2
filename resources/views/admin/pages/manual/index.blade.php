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
                <form action="{{ route('admin.manuals.index') }}" method="GET" class="flex items-center">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search manuals..." value="{{ request('search') }}"
                            class="py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                        @if (request('filter'))
                            <input type="hidden" name="filter" value="{{ request('filter') }}" />
                        @endif
                        <i class="absolute text-gray-400 fas fa-search left-3 top-3"></i>
                    </div>

                    <button type="submit"
                        class="px-4 py-2 ml-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Search
                    </button>

                    @if (request('search'))
                        <a href="{{ route('admin.manuals.index', request('filter') ? ['filter' => request('filter')] : []) }}"
                            class="px-4 py-2 ml-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Clear
                        </a>
                    @endif
                </form>
                <a href="{{ route('admin.manuals.create') }}" title="Add Manual"
                    class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <i class="mr-2 fas fa-plus"></i> Add Manual
                </a>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px">
                <li class="mr-2">
                    <a href="{{ route('admin.manuals.index', request('search') ? ['search' => request('search')] : []) }}"
                        class="inline-block px-4 py-2 font-medium {{ !request('filter') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        All Manuals ({{ $allCount }})
                    </a>
                </li>
                <li class="mr-2">
                    <a href="{{ route('admin.manuals.index', array_merge(['filter' => 'approved'], request('search') ? ['search' => request('search')] : [])) }}"
                        class="inline-block px-4 py-2 font-medium {{ request('filter') == 'approved' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        Approved ({{ $approvedCount }})
                    </a>
                </li>
                <li class="mr-2">
                    <a href="{{ route('admin.manuals.index', array_merge(['filter' => 'pending'], request('search') ? ['search' => request('search')] : [])) }}"
                        class="inline-block px-4 py-2 font-medium {{ request('filter') == 'pending' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        Pending ({{ $pendingCount }})
                    </a>
                </li>
                <li class="mr-2">
                    <a href="{{ route('admin.manuals.index', array_merge(['filter' => 'rejected'], request('search') ? ['search' => request('search')] : [])) }}"
                        class="inline-block px-4 py-2 font-medium {{ request('filter') == 'rejected' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        Rejected ({{ $rejectedCount }})
                    </a>
                </li>
            </ul>
        </div>

        <!-- Manuals Table -->
        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            @if ($manuals->count() > 0)
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
                        <!-- Manual Row -->
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
                                            {{ $manual->admin->name ?? 'Unknown Admin' }} <span
                                                class="text-xs font-medium bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Admin</span>
                                        @elseif ($manual->uploaded_by)
                                            {{ $manual->user->name ?? 'Unknown User' }}
                                        @else
                                            <span class="text-gray-500">Unknown</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        @if ($manual->uploaded_by_admin)
                                            {{ $manual->admin->email ?? '' }}
                                        @elseif ($manual->uploaded_by)
                                            {{ $manual->user->email ?? '' }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full text-violet-800 bg-violet-100 ">
                                        {{ $manual->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full
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
                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                    <div class="flex gap-2">
                                        <!-- Download button -->
                                        <a href="{{ route('admin.manuals.download', $manual) }}"
                                            class="inline text-indigo-600 hover:text-indigo-900" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <!-- Approve button -->
                                        <form action="{{ route('admin.manuals.approve', $manual->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900"
                                                title="Approve">
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
                                        <!-- Delete button -->
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
            @else
                <div class="p-6 text-center">
                    <p class="text-gray-500">
                        @if (request('search'))
                            No manuals found matching '{{ request('search') }}'.
                        @elseif(request('filter'))
                            No {{ request('filter') }} manuals found.
                        @else
                            No manuals found.
                        @endif
                    </p>
                </div>
            @endif

            <!-- Pagination -->
            <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ $manuals->count() }}</span>
                                {{ Str::plural('manual', $manuals->count()) }}
                                @if (request('search'))
                                    for search "{{ request('search') }}"
                                @endif
                                @if (request('filter'))
                                    with status "{{ request('filter') }}"
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
