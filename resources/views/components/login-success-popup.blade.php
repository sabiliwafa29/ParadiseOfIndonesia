@if(session('login_success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Welcome Back!',
            html: '<p class="text-lg">Hi <strong>{{ session('user_name') }}</strong>,</p><p>You\'re successfully logged in!</p>',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            allowOutsideClick: false,
            didOpen: () => {
                // Auto redirect after popup closes
                setTimeout(() => {
                    window.location.href = '{{ route('home') }}';
                }, 2000);
            }
        });
    });
</script>
@endif