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

    <div class="container px-4 py-6 mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Add New Manual</h1>
            <a href="{{ route('admin.manuals.index') }}"
                class="px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700">
                <i class="mr-2 fas fa-arrow-left"></i> Back to Manuals
            </a>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-md">
            @if ($errors->any())
                <div class="p-4 mb-6 text-red-700 bg-red-100 border-l-4 border-red-500" role="alert">
                    <p class="font-bold">Please fix the following errors:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.manuals.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block mb-2 text-sm font-bold text-gray-700">Title</label>
                    <input type="text" name="manual_title" id="title" value="{{ old('title') }}" required
                        placeholder="e.g. Samsung Refrigerator Model RT29K5030S8"
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="description" class="block mb-2 text-sm font-bold text-gray-700">Description</label>
                    <textarea name="manual_description" id="description" rows="4" required
                        placeholder="Provide a brief description of the manual content and what products it covers..."
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block mb-2 text-sm font-bold text-gray-700">Category</label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                        <option value="" disabled selected>Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="manual_file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Manual
                        File (PDF
                        only)</label>
                    <input type="file" name="manual_file" id="manual_file"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none ">
                    <p class="mt-1 text-sm text-gray-500 ">Only PDF files are
                        accepted. Maximum file size: 10MB.</p>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit"
                        class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <i class="mr-2 fas fa-save"></i> Add Manual
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
