@extends('layouts.app')

@section('title', 'Мој профил')

@section('content')
<div class="container-fluid py-4">
    <!-- Назад дугме -->
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Назад
        </a>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Профил корисника</h4>
                        <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-edit"></i> Уреди профил
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Основне информације -->
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center"
                                  style="width: 80px; height: 80px;">
                                <i class="fas fa-user fa-2x text-white"></i>
                            </div>
                        </div>
                        <h3>{{ $user->name }}</h3>
                        <span class="badge bg-info">{{ ucfirst($user->role) }}</span>
                    </div>

                    <hr>

                    <!-- Детаљи профила -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Име и презиме</h6>
                            <p class="fs-5">{{ $user->name }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Email</h6>
                            <p class="fs-5">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Телефон</h6>
                            <p class="fs-5">{{ $user->telefon ?? 'Није унето' }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Рола</h6>
                            <p class="fs-5">
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
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Адреса</h6>
                            <p class="fs-5">{{ $user->adresa ?? 'Није унето' }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Град</h6>
                            <p class="fs-5">{{ $user->grad ?? 'Није унето' }}</p>
                        </div>
                    </div>

                    <!-- Додатне информације -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Креиран</h6>
                            <p class="fs-5">{{ $user->created_at->format('d.m.Y. H:i') }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Ажуриран</h6>
                            <p class="fs-5">{{ $user->updated_at->format('d.m.Y. H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rounded-circle {
    border-radius: 50% !important;
}
</style>
@endsection
