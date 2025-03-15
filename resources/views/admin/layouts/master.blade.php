<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manual Manager - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-roboto">
    <!-- Sidebar -->
    <div class="flex h-screen">
        @include('admin.layouts.sidebar')
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Navigation -->
            @include('admin.layouts.header')

            <!-- Main Content Area -->
            @yield('content')
        </div>
    </div>


</body>

</html>
