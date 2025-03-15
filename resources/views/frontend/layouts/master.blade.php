<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home - Instruction Manuals Library</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-roboto">
    <div class="flex flex-col min-h-screen">
        @include('frontend.layouts.header');
        <!-- Main Content -->
        <main class="flex-grow">
            @include('frontend.pages.home.sections.hero-section');
            <!-- Content Section -->
            <div class="relative -mt-32">
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    @include('frontend.pages.home.sections.category-section');
                    @include('frontend.pages.home.sections.cta-section');
                </div>
            </div>
        </main>
        @include('frontend.layouts.footer');
    </div>
</body>

</html>
