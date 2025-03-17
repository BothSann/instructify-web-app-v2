@extends ('frontend.layouts.master')
@section('content')
    <div class="max-w-3xl px-4 py-8 mx-auto sm:px-6 lg:px-8">
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
        <!-- Manual Details Card -->
        <div class="mb-6 overflow-hidden bg-white rounded-lg shadow">
            <div class="flex items-start px-4 py-4 sm:px-6">
                <div class="flex-shrink-0 mr-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded">
                        <i class="text-xl text-blue-600 fas fa-file-pdf"></i>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ $manual->title }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Uploaded by: {{ $manual->user->name }} • {{ $manual->created_at->format('M d, Y') }}
                    </p>
                    <div class="flex mt-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                            {{ $manual->category->name }}
                        </span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Approved
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Complaint Form Card -->
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h1 class="text-xl font-semibold text-gray-900">
                    Submit a Complaint
                </h1>
                <p class="mt-1 text-sm text-gray-600">
                    Please let us know what's wrong with this manual so we can
                    address the issue.
                </p>
            </div>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="flex items-center p-4 mb-4 text-sm text-red-800 bg-gray-800 rounded-lg dark:bg-red-50 dark:text-red-400"
                        role="alert">
                        <svg class="inline w-4 h-4 shrink-0 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Error:</span> {{ $error }}
                        </div>
                    </div>
                @endforeach
            @endif
            <form method="POST" action="{{ route('complaints.store') }}" class="p-6">
                @csrf
                <input type="hidden" name="manual_id" value="{{ $manual->id }}">

                <!-- Complaint Type -->
                <div class="mb-6">
                    <label for="complaint_type" class="block mb-1 text-sm font-medium text-gray-700">Complaint Type <span
                            class="text-red-500">*</span></label>
                    <select id="complaint_type" name="complaint_type"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="" disabled selected>
                            Select complaint type
                        </option>
                        @foreach ($complaintTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block mb-1 text-sm font-medium text-gray-700">Description <span
                            class="text-red-500">*</span></label>
                    <textarea id="description" name="description" rows="5" placeholder="Please describe the issue in detail."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    <p class="mt-1 text-xs text-gray-500">
                        The more specific you are, the better we can address the
                        problem
                    </p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3">
                    <button type="button"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Submit Complaint
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
