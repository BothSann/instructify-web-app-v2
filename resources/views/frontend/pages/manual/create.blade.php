@extends('frontend.layouts.master')
@section('content')
    <div class="max-w-3xl px-4 py-8 mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h1 class="text-xl font-semibold text-gray-900">
                    Upload a Manual
                </h1>
                <p class="mt-1 text-sm text-gray-600">
                    Share a manual to help others find the instructions they need.
                    Your upload will be reviewed by our team before being published.
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

            <form action="{{ route('manuals.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <!-- Manual Title -->
                <div class="mb-6">
                    <label for="manual_title" class="block mb-1 text-sm font-medium text-gray-700">Manual Title <span
                            class="text-red-500">*</span>
                    </label>
                    <input type="text" id="manual_title" name="manual_title"
                        placeholder="e.g. Samsung Refrigerator Model RT29K5030S8"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                    <p class="mt-1 text-xs text-gray-500">
                        Include the full product name and model number for better
                        searchability
                    </p>
                </div>


                <!-- Category Selection -->
                <div class="mb-6">
                    <label for="category" class="block mb-1 text-sm font-medium text-gray-700">Category <span
                            class="text-red-500">*</span></label>
                    <select id="category" name="category_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="" disabled selected>Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="manual_description" class="block mb-1 text-sm font-medium text-gray-700">Description <span
                            class="text-red-500">*</span></label>
                    <textarea id="manual_description" name="manual_description" rows="4"
                        placeholder="Provide a brief description of the manual content and what products it covers..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    <p class="mt-1 text-xs text-gray-500">
                        Include key information that would help users find this manual
                    </p>
                </div>

                <!-- File Upload -->
                <div class="mb-6">
                    <label for="manual-file" class="block mb-1 text-sm font-medium text-gray-700">Manual File (PDF)
                        <span class="text-red-500">*</span></label>
                    <div class="flex justify-center px-6 pt-5 pb-6 mt-1 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="flex flex-col items-center gap-2">
                            <i class="mb-2 text-3xl text-gray-400 fas fa-file-pdf"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="manual-file"
                                    class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <input id="manual-file" name="manual_file" type="file" class="sr-only" />
                                </label>
                            </div>
                            <p id="file-name" class="mt-2 text-sm text-green-800"></p>
                        </div>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="mb-6">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" required
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="font-medium text-gray-700">I confirm that I have the right to
                                share this
                                manual</label>
                            <p class="text-gray-500">
                                I understand that copyrighted materials should not be
                                uploaded without permission.
                            </p>
                        </div>
                    </div>
                </div>


                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3">
                    <button type="button"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Upload Manual
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('manual-file').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : '';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
@endpush
