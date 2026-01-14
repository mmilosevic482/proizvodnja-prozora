@extends('layouts.app')

@section('title', 'Уреди профил')

@section('content')
<div class="container-fluid py-4">
    <!-- Назад дугме -->
    <div class="mb-4">
        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Назад на профил
        </a>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Уреди профил</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Основне информације -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Име и презиме *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Контакт информације -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="telefon" class="form-label">Телефон</label>
                                <input type="text" class="form-control @error('telefon') is-invalid @enderror"
                                       id="telefon" name="telefon" value="{{ old('telefon', $user->telefon) }}">
                                @error('telefon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="grad" class="form-label">Град</label>
                                <input type="text" class="form-control @error('grad') is-invalid @enderror"
                                       id="grad" name="grad" value="{{ old('grad', $user->grad) }}">
                                @error('grad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Адреса -->
                        <div class="mb-4">
                            <label for="adresa" class="form-label">Адреса</label>
                            <textarea class="form-control @error('adresa') is-invalid @enderror"
                                      id="adresa" name="adresa" rows="2">{{ old('adresa', $user->adresa) }}</textarea>
                            @error('adresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Рола (само приказ) -->
                        <div class="mb-4">
                            <label class="form-label">Рола</label>
                            <div class="form-control bg-light">
                                @switch($user->role)
                                    @case('admin')
                                        <span class="badge bg-danger">Администратор</span>
                                        @break
                                    @case('menadzer')
                                        <span class="badge bg-warning text-dark">Менаџер</span>
                                        @break
                                    @case('radnik')
                                        <span class="badge bg-info">Радник</span>
                                        @break
                                    @case('klijent')
                                        <span class="badge bg-success">Клијент</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $user->role }}</span>
                                @endswitch
                                <small class="text-muted ms-2">(Рола се не може мењати)</small>
                            </div>
                        </div>

                        <!-- Дугмићи -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                                Откажи
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Сачувај промене
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
