@extends('layouts.app')

@section('title', 'Ganti Kata Sandi')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="h3 fw-bold">Ganti Kata Sandi</h2>
                            <p class="text-muted mt-2">
                                Masukkan kata sandi lama dan baru untuk mengubah kata sandi Anda.
                            </p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('password.change') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Kata Sandi Lama</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                       id="current_password" name="current_password"
                                       placeholder="••••••••" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">Kata Sandi Baru</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                       id="new_password" name="new_password"
                                       placeholder="••••••••" required>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" class="form-control"
                                       id="new_password_confirmation" name="new_password_confirmation"
                                       placeholder="••••••••" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Ganti Kata Sandi</button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ route('dashboard') }}" class="text-primary">Kembali ke Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
