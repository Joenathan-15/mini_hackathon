@extends('layouts.auth-form')

@section("title", "Masuk ke Lentera")
@section("head")
<style>
    @keyframes float-slow {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .animate-float-slow {
        animation: float-slow 6s ease-in-out infinite;
    }
</style>
@endsection

@section("body")
<section class="min-h-screen flex items-center justify-center relative overflow-hidden bg-base-100">
    <div id="error-notification" class="toast toast-top toast-center hidden">
        <div class="alert alert-error bg-error/95 text-error-content backdrop-blur-md shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id="error-message">Login gagal!</span>
        </div>
    </div>

    <!-- Background Glow -->
    <div class="absolute inset-0">
        <div class="absolute w-96 h-96 bg-primary/10 rounded-full blur-3xl top-0 left-0 animate-float-slow"></div>
        <div class="absolute w-80 h-80 bg-primary/10 rounded-full blur-3xl bottom-10 right-10 animate-float-slow"></div>
    </div>

    <!-- Back Button -->
    <a href="{{ url('/') }}"
        class="absolute top-6 left-6 flex items-center gap-2 px-4 py-2 rounded-full bg-base-100/70 border border-base-300 backdrop-blur-md shadow-md hover:shadow-lg transition-all duration-300 group">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 text-primary transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="text-sm font-medium text-base-content/80 group-hover:text-primary transition-colors">
            Kembali
        </span>
    </a>

    <!-- Login Card -->
    <div
        class="relative z-10 w-full max-w-md bg-base-100/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-base-200 p-8 space-y-6 animate-fade-in-up">
        <div class="text-center">
            <img src="{{ asset('assets/lentera-1.png') }}" alt="Lentera Logo"
                class="w-16 h-16 mx-auto mb-3 animate-float-slow">
            <h1 class="text-3xl font-bold bg-linear-to-r from-primary to-secondary bg-clip-text text-transparent">
                Selamat Datang 👋
            </h1>
            <p class="text-base-content/60 mt-2">Masuk ke akun Lentera kamu dan mulai berbagi ilmu ✨</p>
        </div>

        <form id="login-form" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label class="label">
                    <span class="label-text font-medium text-base-content/80">Email</span>
                </label>
                <input id="email" type="email" name="email" placeholder="contoh@email.com"
                    class="input input-bordered w-full rounded-xl focus:ring-2 focus:ring-primary/50" required>
                <p id="email-error" class="text-error text-sm hidden mt-1"></p>
            </div>

            <!-- Password -->
            <div>
                <label class="label">
                    <span class="label-text font-medium text-base-content/80">Kata Sandi</span>
                </label>
                <input id="password" type="password" name="password" placeholder="Masukkan kata sandimu"
                    class="input input-bordered w-full rounded-xl focus:ring-2 focus:ring-primary/50" required>
                <p id="password-error" class="text-error text-sm hidden mt-1"></p>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input id="remember" type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-sm">
                    <span class="text-base-content/70">Ingat saya</span>
                </label>
            </div>

            <!-- Login Button -->
            <button id="login-btn" type="submit"
                class="btn btn-primary w-full rounded-full mt-4 shadow-lg hover:shadow-primary/30 transition-all duration-300">
                <span id="btn-text">Masuk Sekarang 🚀</span>
                <span id="btn-loading" class="hidden loading loading-spinner"></span>
            </button>
        </form>

        <!-- Register Link -->
        <div class="text-center pt-4">
            <p class="text-sm text-base-content/60">
                Belum punya akun?
                <a href="{{ url('/register') }}" class="text-primary font-medium hover:underline">Daftar di sini</a>
            </p>
        </div>
    </div>

    @if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
        <p style="color:red;">{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <script>
        function showErrorNotification(message) {
            const $notification = $('#error-notification');
            const $message = $('#error-message');

            $message.text(message);
            $notification.removeClass('hidden');

            setTimeout(() => {
                $notification.addClass('hidden');
            }, 2000);
        }

        $(document).ready(function() {
            // Handle form submission with jQuery
            $('#login-form').on('submit', function(e) {
                e.preventDefault();

                showLoading(true);

                // Clear old errors
                $('.text-error').addClass('hidden').text('');
                $('.input').removeClass('input-error');

                $.ajax({
                    url: "{{ url('/login') }}",
                    method: "POST",
                    data: {
                        email: $('#email').val(),
                        password: $('#password').val(),
                        remember: $('#remember').is(':checked'),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        window.location.href = "{{ route('dashboard') }}";
                    },
                    error: function(xhr) {
                        showLoading(false);

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                $('#' + field + '-error').text(messages[0]).removeClass('hidden');
                                $('#' + field).addClass('input-error');
                            });
                        } else {
                            const errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan.';
                            showErrorNotification(errorMessage);
                        }
                    }
                });
            });

            function showLoading(show) {
                const $btn = $('#login-btn');
                const $text = $('#btn-text');
                const $loading = $('#btn-loading');

                if (show) {
                    $btn.prop('disabled', true)
                        .addClass('cursor-not-allowed opacity-70');
                    $text.addClass('hidden');
                    $loading.removeClass('hidden');
                } else {
                    $btn.prop('disabled', false)
                        .removeClass('cursor-not-allowed opacity-70');
                    $text.removeClass('hidden');
                    $loading.addClass('hidden');
                }
            }
        });
    </script>
</section>
@endsection
