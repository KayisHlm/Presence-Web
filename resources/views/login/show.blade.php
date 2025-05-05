<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Log In</h2>
                    <p class="text-muted">Please log in with your existing account</p>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('login.submit') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" 
                                       class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" 
                                       class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Log In</button>
                            </div>
                        </form>

                        @if(session('gagal'))
                        <div class="alert alert-danger mt-3" role="alert">{{ session('gagal') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small>Don't have account? <a href="{{ route('registration.show') }}">Sign up here</a>.</small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
