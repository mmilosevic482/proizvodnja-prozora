<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registracija - Proizvodnja Prozora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .register-header {
            background: #2c3e50;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="register-header text-center">
            <h4>🎯 Proizvodnja Prozora</h4>
            <p class="mb-0">Registracija novog naloga</p>
        </div>

        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Ime i prezime</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email adresa</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Lozinka</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <small class="text-muted">Minimum 8 karaktera</small>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Potvrdi lozinku</label>
                    <input type="password" class="form-control" id="password_confirmation"
                           name="password_confirmation" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        📝 Registruj se
                    </button>
                </div>
            </form>

            <hr class="my-4">

            <div class="text-center">
                <p class="mb-2">Već imaš nalog?</p>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                    🔐 Prijavi se
                </a>
            </div>
        </div>
    </div>
</body>
</html>
