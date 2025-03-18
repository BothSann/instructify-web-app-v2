<!-- Footer -->
<footer class="mt-12 bg-white border-t border-gray-200">
    <div class="px-4 py-12 mx-auto overflow-hidden max-w-7xl sm:px-6 lg:px-8">
        <p class="text-base text-center text-gray-400 ">
            &copy; <span id="year"></span> | Made with 💖 by Both Sann | All rights reserved.
        </p>
    </div>
</footer>

@push('scripts')
    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
@endpush
