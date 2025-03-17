<!-- Hero Section with Search -->
<section class="pb-32 bg-indigo-700">
    <div class="px-4 py-16 mx-auto max-w-7xl sm:py-24 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-white sm:text-5xl sm:tracking-tight lg:text-6xl">
                Find Any Manual
            </h1>
            <p class="max-w-xl mx-auto mt-6 text-xl text-indigo-200">
                Search our library of product manuals to find instructions for
                your devices.
            </p>
        </div>
        <div class="flex items-center justify-center max-w-xl mx-auto mt-10">
            <form action="{{ route('manuals.index') }}" method="GET">
                <div class="flex rounded-md shadow-sm">
                    <button type="submit"
                        class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-white bg-indigo-900 border border-transparent rounded-md hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span>Start Searching Now</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
