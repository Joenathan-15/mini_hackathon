<!-- Navbar -->
<div
    class="navbar bg-base-100/80 backdrop-blur-xl shadow-md sticky top-0 z-50 px-4 md:px-12 transition-all duration-300 justify-between">
    <!-- Left: Logo + Brand -->
    <div class="flex items-center gap-3">
        @auth
        <img src="{{ asset('assets/lentera-1.png') }}" alt="Lentera"
            class="w-10 h-10 rounded-xl object-cover drop-shadow-md">
        <a href="/dashboard"
            class="text-2xl font-bold tracking-tight bg-linear-to-r from-primary to-secondary bg-clip-text text-transparent hover:opacity-90 transition-opacity">
            Lentera
        </a>
        @endauth
        @guest
        <img src="{{ asset('assets/lentera-1.png') }}" alt="Lentera"
            class="w-10 h-10 rounded-xl object-cover drop-shadow-md">
        <a href="/"
            class="text-2xl font-bold tracking-tight bg-linear-to-r from-primary to-secondary bg-clip-text text-transparent hover:opacity-90 transition-opacity">
            Lentera
        </a>
        @endguest
    </div>

    <!-- Center: Navigation links (Desktop only) -->
    <div class="hidden md:flex gap-8 text-base font-medium text-base-content/80">
        @guest
        <a href="{{url("/")}}" class="relative group">
            <span class="transition-colors group-hover:text-primary">Beranda</span>
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all group-hover:w-full"></span>
        </a>
        @endguest
        @auth
        <a href="{{url("/dashboard")}}" class="relative group">
            <span class="transition-colors group-hover:text-primary">Beranda</span>
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all group-hover:w-full"></span>
        </a>
        @endauth
        <a href="{{url("/explore")}}" class="relative group">
            <span class="transition-colors group-hover:text-primary">Jelajahi</span>
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all group-hover:w-full"></span>
        </a>

        <!-- Tampilkan Upload di center hanya jika sudah login -->
        @auth
        <a href="{{url("/dashboard")}}" class="relative group">
            <span class="transition-colors group-hover:text-primary">Dashboard</span>
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all group-hover:w-full"></span>
        </a>
        @endauth
    </div>

    <!-- Right: Buttons (Desktop) -->
    <div class="hidden md:flex items-center gap-4">
        @auth
        <!-- Tampilkan ini jika user sudah login -->
        <div class="flex items-center gap-4">
            <!-- Tombol Upload -->
            <a href="{{url("/upload")}}"
                class="btn btn-sm btn-primary px-5 rounded-full hover:shadow-lg hover:shadow-primary/30 transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                Upload
            </a>

            <!-- User Dropdown -->
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div
                        class="w-8 rounded-full bg-linear-to-r from-primary to-secondary text-white flex items-center justify-center font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    <li class="menu-title">
                        <span>Halo, {{ auth()->user()->name }}</span>
                    </li>
                    <li><a href="{{url("/profile")}}">Profile Saya</a></li>
                    <li><a href="{{url("/my-materials")}}">Materi Saya</a></li>
                    <li>
                        <hr>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left">Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        @else
        <!-- Tampilkan ini jika user belum login -->
        <a href="{{url("/login")}}"
            class="btn btn-sm btn-outline btn-primary px-5 rounded-full hover:shadow-md transition-all">
            Masuk
        </a>
        <a href="{{url("/register")}}"
            class="btn btn-sm btn-primary px-5 rounded-full hover:shadow-lg hover:shadow-primary/30 transition-all">
            Daftar
        </a>
        @endauth
    </div>

    <!-- Mobile Menu Button -->
    <div class="md:hidden">
        <button id="menu-toggle" class="btn btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>
</div>

<!-- Full-width Dropdown Menu -->
<div id="mobile-menu"
    class="sticky top-15 left-0 right-0 bg-base-100/95 backdrop-blur-xl border-t border-base-200 shadow-lg opacity-0 scale-y-95 origin-top hidden z-40 text-base-content font-medium text-center md:hidden transition-all duration-300">
    <div class="grid grid-cols-2 gap-2 py-4 px-3 sm:grid-cols-4">
        @guest
        <a href="{{url("/")}}"
            class="py-3 rounded-xl hover:bg-base-200 transition-all flex flex-col items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 text-primary" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m0-8H5a2 2 0 00-2 2v8h18v-8a2 2 0 00-2-2h-4" />
            </svg>
            Beranda
        </a>
        @endguest
        @auth
        <a href="{{url("/")}}"
            class="py-3 rounded-xl hover:bg-base-200 transition-all flex flex-col items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 text-primary" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m0-8H5a2 2 0 00-2 2v8h18v-8a2 2 0 00-2-2h-4" />
            </svg>
            Beranda
        </a>
        @endauth
        <a href="{{url("/explore")}}"
            class="py-3 rounded-xl hover:bg-base-200 transition-all flex flex-col items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 text-primary" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
            Jelajahi
        </a>

        <!-- Tampilkan Upload di mobile hanya jika sudah login -->
        @auth
        <a href="{{url("/dashboard")}}"
            class="py-3 rounded-xl hover:bg-base-200 transition-all flex flex-col items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 text-primary" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            Dashboard
        </a>
        @endauth

        @auth
        <!-- Menu untuk user yang sudah login di mobile -->
        <a href="{{url("/profile")}}"
            class="py-3 rounded-xl hover:bg-base-200 transition-all flex flex-col items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 text-primary" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Profile
        </a>

        <a href="{{url("/my-materials")}}"
            class="py-3 rounded-xl hover:bg-base-200 transition-all flex flex-col items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 text-primary" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Materi Saya
        </a>

        <form method="POST" action="{{ route('logout') }}" class="col-span-2">
            @csrf
            <button type="submit"
                class="w-full py-3 rounded-xl hover:bg-base-200 transition-all flex flex-col items-center justify-center text-error">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>
        @else
        <!-- Menu untuk user belum login di mobile -->
        <a href="{{url("/login")}}"
            class="py-3 rounded-xl hover:bg-base-200 transition-all flex flex-col items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 text-primary" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a4 4 0 11-8 0 4 4 0 018 0zM12 14v7m0-7H6a2 2 0 00-2 2v5h16v-5a2 2 0 00-2-2h-6z" />
            </svg>
            Masuk
        </a>

        <a href="{{url("/register")}}"
            class="py-3 rounded-xl hover:bg-base-200 transition-all flex flex-col items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 text-primary" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0 2.21 1.79 4 4 4s4-1.79 4-4-1.79-4-4-4-4 1.79-4 4zM6 20v-2a4 4 0 014-4h8a4 4 0 014 4v2" />
            </svg>
            Daftar
        </a>
        @endauth
    </div>
</div>

<!-- jQuery Script -->
<script>
    $(function () {
    const menu = $("#mobile-menu");

    $("#menu-toggle").on("click", function () {
      if (menu.hasClass("hidden")) {
        menu.removeClass("hidden");
        setTimeout(() => menu.addClass("opacity-100 scale-y-100").removeClass("opacity-0 scale-y-95"), 10);
      } else {
        menu.removeClass("opacity-100 scale-y-100").addClass("opacity-0 scale-y-95");
        setTimeout(() => menu.addClass("hidden"), 250);
      }
    });

    // Close when clicking link
    $("#mobile-menu a").on("click", function () {
      menu.removeClass("opacity-100 scale-y-100").addClass("opacity-0 scale-y-95");
      setTimeout(() => menu.addClass("hidden"), 250);
    });

    // Close when clicking outside
    $(document).on("click", function (event) {
      if (!$(event.target).closest('#menu-toggle').length && !$(event.target).closest('#mobile-menu').length) {
        menu.removeClass("opacity-100 scale-y-100").addClass("opacity-0 scale-y-95");
        setTimeout(() => menu.addClass("hidden"), 250);
      }
    });
  });
</script>
