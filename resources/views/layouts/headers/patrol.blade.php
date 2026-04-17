<nav class="bg-[#00204F] text-white px-4 py-3" x-data="{ mobileMenuOpen: false }">
  <div class="flex flex-col md:flex-row justify-between items-center gap-4">
    <!-- Logo + Hamburger -->
    <div class="w-full md:w-auto flex justify-between items-center">
      <a href="{{ route('patrol.dashboard') }}" class="flex items-center gap-3">
        <img src="https://cdn.jsdelivr.net/gh/OpenBristolData/SLTMobitel-Resource@main/logo.png" alt="Logo" class="h-10" />
      </a>
      <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-white focus:outline-none">
        <i class="fa-solid fa-bars text-2xl"></i>
      </button>
    </div>

    <!-- Main Menu -->
    <div 
      x-show="mobileMenuOpen || window.innerWidth >= 768"
      @click.outside="mobileMenuOpen = false"
      class="w-full md:w-auto"
      x-cloak
    >
    <ul class="flex flex-col md:flex-row items-start md:items-center gap-2 md:gap-4 text-sm md:text-base py-4 md:py-0">
  <li>
    <a 
      href="{{ route('patrol.dashboard') }}" 
      class="flex items-center gap-2 px-3 py-2 relative
        {{ request()->is('patrol/dashboard') 
           ? 'text-green-400 font-semibold' 
           : 'text-white hover:text-white after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0.5 after:bg-green-400 after:scale-x-0 after:origin-left after:transition-transform after:duration-200 hover:after:scale-x-100' }}">
      <i class="fa-solid fa-gauge"></i> Dashboard
    </a>
  </li>
  <li>
    <a 
      href="{{ route('patrol.timecards.index') }}" 
      class="flex items-center gap-2 px-3 py-2 relative
        {{ request()->is('patrol/timecards*') 
           ? 'text-green-400 font-semibold' 
           : 'text-white hover:text-white after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0.5 after:bg-green-400 after:scale-x-0 after:origin-left after:transition-transform after:duration-200 hover:after:scale-x-100' }}">
      <i class="fa-solid fa-clock"></i> Timecards
    </a>
  </li>
</ul>
    </div>

    <!-- User Dropdown -->
    <div x-data="{ open: false }" class="relative">
      <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded hover:text-green-400">
        <i class="fa-solid fa-circle-user text-2xl"></i>
        <span>{{ Auth::user()->employee_id ?? 'Patrol Officer' }}</span>
        <i class="fa-solid fa-caret-down"></i>
      </button>

      <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-md z-50 text-gray-800">
         
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-blue-100">
            <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
          </button>
        </form>
      </div>
    </div>
  </div>
</nav>