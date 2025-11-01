@extends("layouts.app")
@section("title","Landing ")
@section("head")
<style>
    @keyframes float-slow {

        0%,
        100% {
            transform: translateY(0) translateX(0);
        }

        50% {
            transform: translateY(-20px) translateX(10px);
        }
    }

    @keyframes float-medium {

        0%,
        100% {
            transform: translateY(0) translateX(0);
        }

        50% {
            transform: translateY(-15px) translateX(-15px);
        }
    }

    @keyframes float-fast {

        0%,
        100% {
            transform: translateY(0) translateX(0);
        }

        50% {
            transform: translateY(-10px) translateX(5px);
        }
    }

    @keyframes pulse-slow {

        0%,
        100% {
            opacity: 0.3;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(1.05);
        }
    }

    @keyframes pulse-medium {

        0%,
        100% {
            opacity: 0.2;
            transform: scale(1);
        }

        50% {
            opacity: 0.4;
            transform: scale(1.03);
        }
    }

    @keyframes pulse-fast {

        0%,
        100% {
            opacity: 0.1;
            transform: scale(1);
        }

        50% {
            opacity: 0.3;
            transform: scale(1.02);
        }
    }

    @keyframes slide-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scale-in {
        from {
            transform: scaleX(0);
        }

        to {
            transform: scaleX(1);
        }
    }

    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scroll-indicator {
        0% {
            transform: translateY(0);
            opacity: 0.7;
        }

        100% {
            transform: translateY(12px);
            opacity: 0;
        }
    }

    /* Animation Classes */
    .animate-float-slow {
        animation: float-slow 6s ease-in-out infinite;
    }

    .animate-float-medium {
        animation: float-medium 4s ease-in-out infinite;
    }

    .animate-float-fast {
        animation: float-fast 3s ease-in-out infinite;
    }

    .animate-pulse-slow {
        animation: pulse-slow 8s ease-in-out infinite;
    }

    .animate-pulse-medium {
        animation: pulse-medium 6s ease-in-out infinite;
    }

    .animate-pulse-fast {
        animation: pulse-fast 4s ease-in-out infinite;
    }

    .animate-slide-up {
        animation: slide-up 1s ease-out forwards;
    }

    .animate-slide-up-delay {
        animation: slide-up 1s ease-out 0.3s both;
    }

    .animate-scale-in {
        animation: scale-in 1s ease-out 0.8s forwards;
    }

    .animate-fade-in-up {
        animation: fade-in-up 1s ease-out 0.6s both;
    }

    .animate-fade-in-up-delay {
        animation: fade-in-up 1s ease-out 0.9s both;
    }

    .animate-scroll-indicator {
        animation: scroll-indicator 2s ease-in-out infinite;
    }

    .test {
background: linear-gradient(0deg, #FFF7E1 0%, #FFF7E1 70%, #FFC94A 100%);
    }
</style>
@endsection

@section("body")
<section
    class="test relative min-h-screen flex items-center justify-center overflow-hidden from-base-100 via-primary/5 to-secondary/5">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Floating particles -->
        <div class="absolute w-2 h-2 bg-primary/30 rounded-full top-1/4 left-1/4 animate-float-slow"></div>
        <div class="absolute w-3 h-3 bg-secondary/40 rounded-full top-1/3 right-1/4 animate-float-medium"></div>
        <div class="absolute w-1.5 h-1.5 bg-primary/20 rounded-full bottom-1/3 left-1/3 animate-float-fast"></div>
        <div class="absolute w-2.5 h-2.5 bg-secondary/30 rounded-full bottom-1/4 right-1/3 animate-float-slow"></div>

        <!-- Gradient orbs -->
        <div
            class="absolute w-80 h-80 bg-linear-to-r from-primary/15 to-secondary/15 rounded-full blur-3xl -top-20 -left-20 animate-pulse-slow">
        </div>
        <div
            class="absolute w-96 h-96 bg-linear-to-l from-secondary/10 to-primary/10 rounded-full blur-3xl -bottom-32 -right-32 animate-pulse-medium">
        </div>
        <div
            class="absolute w-64 h-64 bg-linear-to-br from-primary/10 to-transparent rounded-full blur-3xl top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-pulse-fast">
        </div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 text-center px-6 md:px-12 max-w-4xl mx-auto">
        <!-- Animated Title -->
        <div class="mb-6 overflow-hidden">
            <h1
                class="text-5xl md:text-7xl lg:text-8xl font-black tracking-tight mb-4 bg-linear-to-r from-primary via-primary/90 to-secondary bg-clip-text text-transparent animate-slide-up">
                Terangi<br class="hidden md:block">
                <span
                    class="relative inline-block bg-linear-to-r from-primary to-secondary bg-clip-text text-transparent">
                    Perjalanan
                    <span
                        class="absolute -bottom-2 left-0 w-full h-1 bg-linear-to-r from-primary to-secondary transform scale-x-0 animate-scale-in"></span>
                </span>
                <br class="hidden md:block">
                Belajarmu <span class="text-primary animate-bounce inline-block">✨</span>
            </h1>
        </div>

        <!-- Animated Subtitle -->
        <div class="mb-10 overflow-hidden">
            <p class="text-xl md:text-2xl leading-relaxed max-w-2xl mx-auto animate-slide-up-delay text-gray-600">
                Lentera adalah platform berbagi dan menjelajahi materi belajar — tempat di mana pengetahuan menyala dan
                tumbuh bersama komunitas.
            </p>
        </div>

        <!-- Animated CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-5 justify-center items-center animate-fade-in-up">
            <a href="/register"
                class="group relative overflow-hidden btn btn-primary btn-lg md:btn-wide rounded-full shadow-2xl hover:shadow-primary/40 transition-all duration-500 transform hover:-translate-y-1">
                <span class="relative z-10 flex items-center gap-2">
                    Mulai Sekarang
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </span>
                <span
                    class="absolute inset-0 bg-linear-to-r from-primary to-secondary opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>

            <a href="/explore"
                class="group btn btn-outline btn-primary btn-lg md:btn-wide rounded-full border-2 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <span class="flex items-center gap-2">
                    Jelajahi Materi
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
            </a>
        </div>

        <!-- Additional Info -->
        <div class="mt-12 animate-fade-in-up-delay">
            <div class="flex flex-wrap justify-center gap-8 text-base-content/60 text-sm md:text-base">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
                    <span class="text-gray-600">1000+ Materi Belajar</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-secondary rounded-full animate-pulse"></div>
                    <span class="text-gray-600">Komunitas Aktif</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
                    <span class="text-gray-600">Konten Gratis</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
