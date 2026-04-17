<!-- Admin Nav -->
<nav class="bg-[#00204F] text-white px-4 py-3" x-data="{ mobileMenuOpen: false }">
  <div class="flex flex-col md:flex-row justify-between items-center gap-4">
    <!-- Logo + Hamburger -->
    <div class="w-full md:w-auto flex justify-between items-center">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
        <img src="https://cdn.jsdelivr.net/gh/OpenBristolData/SLTMobitel-Resource@main/logo.png" alt="Logo" class="h-10" />
      </a>
      <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-white focus:outline-none">
        <i class="fa-solid fa-bars text-2xl"></i>
      </button>
    </div>

    <!-- Main Menu -->
    <div x-show="mobileMenuOpen || window.innerWidth >= 768" @click.outside="mobileMenuOpen = false" class="w-full md:w-auto" x-cloak>
      <ul class="flex flex-col md:flex-row items-start md:items-center gap-2 md:gap-4 text-sm md:text-base py-4 md:py-0">
        <!-- Add Dropdown -->
          <li>
    <a 
      href="{{ route('admin.dashboard') }}" 
      class="flex items-center gap-2 px-3 py-2 relative
        {{ request()->is('admin/dashboard') 
           ? 'text-green-400 font-semibold' 
           : 'text-white hover:text-white after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0.5 after:bg-green-400 after:scale-x-0 after:origin-left after:transition-transform after:duration-200 hover:after:scale-x-100' }}">
      <i class="fa-solid fa-gauge"></i> Dashboard
    </a>
  </li>
        <li class="relative" x-data="{ open: false }">
          <button @click="open = !open" 
                  class="flex items-center gap-2 px-3 py-2 relative
                    {{ request()->is('admin/*/create') 
                       ? 'text-green-400 font-semibold' 
                       : 'text-white hover:text-white after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0.5 after:bg-green-400 after:scale-x-0 after:origin-left after:transition-transform after:duration-200 hover:after:scale-x-100' }}">
            <i class="fa-solid fa-plus"></i> Add
            <i class="fa-solid fa-chevron-down text-sm ml-1"></i>
          </button>
          <div x-show="open" @click.outside="open = false" x-transition 
               class="w-full md:w-44 mt-1 rounded shadow-lg bg-[#00204F] text-white md:absolute md:left-0 z-20">
            <a href="{{ route('admin.companies.create') }}" 
               class="block px-4 py-2 hover:text-green-400 {{ request()->is('admin/companies/create') ? 'text-green-400 font-semibold' : '' }}">Companies</a>
            <a href="{{ route('admin.company_users.create') }}" 
               class="block px-4 py-2 hover:text-green-400 {{ request()->is('admin/company_users/create') ? 'text-green-400 font-semibold' : '' }}">Company Users</a>
            <a href="{{ route('admin.approver.create') }}" 
               class="block px-4 py-2 hover:text-green-400 {{ request()->is('admin/approver/create') ? 'text-green-400 font-semibold' : '' }}">Approver</a>
            <a href="{{ route('admin.security_managers.create') }}" 
               class="block px-4 py-2 hover:text-green-400 {{ request()->is('admin/security_managers/create') ? 'text-green-400 font-semibold' : '' }}">Security Manager</a>
            <a href="{{ route('admin.patrol_officers.create') }}" 
               class="block px-4 py-2 hover:text-green-400 {{ request()->is('admin/patrol_officers/create') ? 'text-green-400 font-semibold' : '' }}">Patrol Officer</a>
            <a href="{{ route('admin.security_officers.create') }}" 
               class="block px-4 py-2 hover:text-green-400 {{ request()->is('admin/security_officers/create') ? 'text-green-400 font-semibold' : '' }}">Security Officers</a>
          </div>
        </li>

        <!-- Manage Dropdown -->
        <li class="relative" x-data="{ open: false }">
          <button @click="open = !open" 
                  class="flex items-center gap-2 px-3 py-2 relative
                    {{ request()->is('admin/*/') 
                       ? 'text-green-400 font-semibold' 
                       : 'text-white hover:text-white after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0.5 after:bg-green-400 after:scale-x-0 after:origin-left after:transition-transform after:duration-200 hover:after:scale-x-100' }}">
            <i class="fa-solid fa-cogs"></i> Manage
            <i class="fa-solid fa-chevron-down text-sm ml-1"></i>
          </button>
          <div x-show="open" @click.outside="open = false" x-transition 
               class="w-full md:w-48 mt-1 rounded shadow-lg bg-[#00204F] text-white md:absolute md:left-0 z-20">
            <a href="{{ route('admin.companies.index') }}" 
               class="block px-4 py-2 hover:text-green-400 {{ request()->is('admin/companies/index') ? 'text-green-400 font-semibold' : '' }}">Companies</a>
            <a href="{{ route('admin.company_users.index') }}" 
               class="block px-4 py-2 hover:text-green-400 {{ request()->is('admin/company_users/index') ? 'text-green-400 font-semibold' : '' }}">Company Users</a>
            <a href="{{ route('admin.approver.index') }}" 
               class="block px-4 py-2 hover:text-green-400 {{ request()->is('admin/approver/index') ? 'text-green-400 font-semibold' : '' }}">Approver</a>
            <a href="{{ route('admin.security_managers.index') }}" 
               class="block px-4 py-2 hover:text-green-400 {{ request()->is('admin/security_managers/index') ? 'text-green-400 font-semibold' : '' }}">Security Manager</a>
            <a href="{{ route('admin.patrol_officers.index') }}" 
               class="block px-4 py-2 hover:text-green-400 {{ request()->is('admin/patrol_officers/index') ? 'text-green-400 font-semibold' : '' }}">Patrol Officer</a>
            <a href="{{ route('admin.security_officers.index') }}" 
               class="block px-4 py-2 hover:text-green-400 {{ request()->is('admin/security_officers/index') ? 'text-green-400 font-semibold' : '' }}">Security Officers</a>
          </div>
        </li>
      </ul>
    </div>

    <!-- Admin Dropdown -->
    <div x-data="{ open: false }" class="relative">
      <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded hover:text-green-400">
        <i class="fa-solid fa-circle-user text-2xl"></i>
        <span>{{ Auth::user()->email ?? 'Administrator' }}</span>
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