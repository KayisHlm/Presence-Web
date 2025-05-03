<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Aplikasi</title>

    <!-- Bootstrap CSS (pastikan di-include di layout utama kalau pakai Blade layout) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Login Aplikasi</h2>
                    <p class="text-muted">Silakan login dengan akun yang sudah terdaftar</p>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('login.submit') }}" method="POST">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" 
                                       class="form-control" required>
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" 
                                       class="form-control" required>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        @if(session('gagal'))
                        <div class="alert alert-danger mt-3" role="alert">{{ session('gagal') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small>Belum punya akun? <a href="{{ route('registration.show') }}">Daftar di sini</a>.</small>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
