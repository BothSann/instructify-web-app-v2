 <!-- Header/Navigation -->
 <header class="bg-white shadow-sm">
     <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
         <div class="flex justify-between h-16">
             <div class="flex">
                 <div class="flex items-center flex-shrink-0 gap-4 mr-4">
                     <i class="text-2xl text-indigo-600 fas fa-book-open"></i>
                     <span class="text-xl font-bold text-gray-800">Instructify Hub</span>
                 </div>
                 <nav class="hidden sm:ml-6 sm:flex sm:space-x-8">
                     <a href="{{ route('homepage') }}"
                         class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-indigo-600 border-b-2 border-indigo-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-700' }}">
                         Home
                     </a>
                     <a href="{{ route('manuals.index') }}"
                         class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('manuals.index') ? 'text-indigo-600 border-b-2 border-indigo-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-700' }} ">
                         Manuals
                     </a>
                     <a href="{{ route('manuals.create') }}"
                         class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('manuals.create') ? 'text-indigo-600 border-b-2 border-indigo-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-700' }}">
                         Upload Manual
                     </a>
                     <a href="{{ route('complaints.create') }}"
                         class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('complaints.create') ? 'text-indigo-600 border-b-2 border-indigo-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-700' }}">
                         Upload Complaint
                     </a>
                     <a href="{{ route('manuals.indexv2') }}"
                         class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('manuals.indexv2') ? 'text-indigo-600 border-b-2 border-indigo-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-700' }}">
                         My Manuals
                     </a>
                     <a href="{{ route('complaints.index') }}"
                         class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('complaints.index') ? 'text-indigo-600 border-b-2 border-indigo-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-700' }}">
                         My Complaints
                     </a>
                 </nav>
             </div>
             <div class="hidden sm:ml-6 sm:flex sm:items-center">
                 <div class="relative ml-3">
                     <div class="flex items-center gap-2">
                         <span class="mr-1 text-xs text-gray-500 ">
                             @auth
                                 {{ Auth::user()->name }}
                             @else
                                 Guest
                             @endauth
                         </span>
                         <button
                             class="flex text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                             <div class="flex items-center justify-center w-8 h-8 bg-indigo-100 rounded-full">
                                 @if (Route::has('login'))
                                     @auth
                                         <a href="{{ route('profile.edit') }}">
                                             <i class="text-sm text-indigo-600 fas fa-user"></i>
                                         </a>
                                     @else
                                         <a href="{{ route('register') }}">
                                             <i class="text-sm text-indigo-600 fas fa-user"></i>
                                         </a>
                                     @endauth
                                 @endif
                             </div>
                         </button>
                         @auth
                             <form action="{{ route('logout') }}" method="POST">
                                 @csrf
                                 <button type="submit"
                                     class="flex text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                     <div class="flex items-center justify-center w-8 h-8 bg-indigo-100 rounded-full">
                                         <i class="text-sm text-indigo-600 fas fa-sign-out-alt"></i>
                                     </div>
                                 </button>
                             </form>
                         @endauth
                     </div>
                 </div>
             </div>
             <div class="flex items-center -mr-2 sm:hidden">
                 <button type="button"
                     class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                     <i class="fas fa-bars"></i>
                 </button>
             </div>
         </div>
     </div>
 </header>
