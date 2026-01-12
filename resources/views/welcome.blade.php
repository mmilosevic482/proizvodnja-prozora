<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proizvodnja Prozora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">Proizvodnja Prozora</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <h1 class="mb-4">Dobrodošli u sistem za proizvodnju prozora</h1>
                <p class="lead mb-4">Upravljajte narudžbinama, proizvodnjom i klijentima</p>

                <div class="d-grid gap-3 col-md-6 mx-auto">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Prijava</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Registracija</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
