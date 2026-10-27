@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h3 class="mb-4 text-center">Đăng nhập</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" 
                           name="password" 
                           class="form-control" 
                           minlength="6" 
                           pattern="^\S*$" 
                           title="Mật khẩu tối thiểu 6 ký tự và không chứa khoảng trắng" 
                           required>
                    <small class="form-text text-muted">Mật khẩu ít nhất 6 ký tự, không có dấu cách</small>
                </div>

                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
            </form>
            <p class="text-center mt-3">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
        </div>
    </div>
</div>
@endsection