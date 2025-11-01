@extends('layouts.auth-form')

@section("title", "Daftar Akun")
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
<section class="min-h-screen flex items-center justify-center relative overflow-hidden bg-base-100">
    <!-- Background Glow -->
    <div class="absolute inset-0">
        <div class="absolute w-96 h-96 bg-primary/10 rounded-full blur-3xl top-10 left-10 animate-float-slow"></div>
        <div class="absolute w-80 h-80 bg-secondary/10 rounded-full blur-3xl bottom-10 right-10 animate-float-slow">
        </div>
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

    <!-- Register Card -->
    <div
        class="relative z-10 w-full max-w-md bg-base-100/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-base-200 p-8 space-y-6 animate-fade-in-up">
        <div class="text-center">
            <img src="{{ asset('assets/lentera-1.png') }}" alt="Lentera Logo"
                class="w-16 h-16 mx-auto mb-3 animate-float-slow">
            <h1 class="text-3xl font-bold bg-linear-to-r from-primary to-secondary bg-clip-text text-transparent">
                Daftar Akun Lentera
            </h1>
            <p class="text-base-content/60 mt-2">Mulai perjalanan belajarmu bersama Lentera 🌟</p>
        </div>

        <form id="register-form" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label class="label">
                    <span class="label-text font-medium text-base-content/80">Nama Lengkap</span>
                </label>
                <input id="name" type="text" name="name" placeholder="Masukkan nama lengkapmu"
                    class="input input-bordered w-full rounded-xl focus:ring-2 focus:ring-primary/50" required>
                <p id="name-error" class="text-error text-sm hidden mt-1"></p>
            </div>

            <!-- Username -->
            <div>
                <label class="label">
                    <span class="label-text font-medium text-base-content/80">Username</span>
                </label>
                <input id="username" type="text" name="username" placeholder="Masukkan username pilihanmu"
                    class="input input-bordered w-full rounded-xl focus:ring-2 focus:ring-primary/50" required>
                <p id="username-error" class="text-error text-sm hidden mt-1"></p>
            </div>

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
                <input id="password" type="password" name="password" placeholder="Minimal 8 karakter"
                    class="input input-bordered w-full rounded-xl focus:ring-2 focus:ring-primary/50" required>
                <p id="password-error" class="text-error text-sm hidden mt-1"></p>
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="label">
                    <span class="label-text font-medium text-base-content/80">Konfirmasi Kata Sandi</span>
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                    placeholder="Ulangi kata sandi"
                    class="input input-bordered w-full rounded-xl focus:ring-2 focus:ring-primary/50" required>
                <p id="password_confirmation-error" class="text-error text-sm hidden mt-1"></p>
            </div>

            <!-- Submit Button -->
            <button id="register-btn" type="submit"
                class="btn btn-primary w-full rounded-full mt-4 shadow-lg hover:shadow-primary/30 transition-all duration-300">
                <span id="btn-text">Daftar Sekarang 🚀</span>
                <span id="btn-loading" class="hidden loading loading-spinner"></span>
            </button>
        </form>

        <div class="text-center pt-4">
            <p class="text-sm text-base-content/60">
                Sudah punya akun?
                <a href="{{url('/login')}}" class="text-primary font-medium hover:underline">Masuk di sini</a>
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
</section>
@endsection

@section("script")
<script>
    $(document).ready(function() {
        function showErrorNotification(message) {
            const $notification = $('#error-notification');
            const $message = $('#error-message');

            $message.text(message);
            $notification.removeClass('hidden');

            setTimeout(() => {
                $notification.addClass('hidden');
            }, 2000);
        }
        $('#register-form').on('submit', function(e) {
            e.preventDefault();

            // Show loading state
            showLoading(true);

            // Clear previous errors
            $('.text-error').addClass('hidden').text('');
            $('.input').removeClass('input-error');

            $.ajax({
                url: "{{ route('register') }}",
                method: "POST",
                data: {
                    name: $('#name').val(),
                    username: $('#username').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    showLoading(false);
                    window.location.href = '/login';
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
        const $btn = $('#register-btn');
        const $text = $('#btn-text');
        const $loading = $('#btn-loading');

        if (show) {
            $btn.prop('disabled', true).addClass('cursor-not-allowed opacity-70');
            $text.addClass('hidden');
            $loading.removeClass('hidden');
        } else {
            $btn.prop('disabled', false).removeClass('cursor-not-allowed opacity-70');
            $text.removeClass('hidden');
            $loading.addClass('hidden');
        }
    }
});
</script>
@endsection
