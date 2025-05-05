<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Aplikasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Sign Up</h2>
                    <p class="text-muted">Fill the form below to Sign Up</p>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('registration.submit') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="id" class="form-label">ID</label>
                                <input type="text" name="id" id="id" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Fullname</label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label for="posisi" class="form-label">Position</label>
                                <input type="text" name="posisi" id="posisi" class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label mb-2">Role</label>
                                <div class="d-flex justify-content-between px-5 text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="admin" value="Admin" required>
                                        <label class="form-check-label" for="admin">Admin</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="karyawan" value="Karyawan" required>
                                        <label class="form-check-label" for="karyawan">Employee</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <input type="hidden" name="gaji" id="gaji" value="0">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Sign Up</button>
                            </div>
                        </form>

                        @if(session('gagal'))
                            <div class="alert alert-danger mt-3" role="alert">{{ session('gagal') }}</div>
                        @endif
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small>Already have account? <a href="{{ route('login.show') }}">Log in here</a>.</small>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
