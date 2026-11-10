@extends('layouts.app')

@section('title', 'Quản lý tài khoản & Đổi mật khẩu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                    <div>
                        <h3 class="fw-bold text-dark mb-1">Hồ sơ cá nhân & Bảo mật</h3>
                        <p class="text-muted small mb-0">Cập nhật thông tin tài khoản và đổi mật khẩu an toàn cho BLOG-WORLD.</p>
                    </div>
                </div>

                @if(session('message'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-1"></i> Vui lòng kiểm tra lại:</div>
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="fw-bold text-secondary fs-6 mb-3"><i class="fas fa-info-circle me-1"></i> Thông tin cơ bản</h5>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Họ tên / Tên tác giả</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Địa chỉ Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <h5 class="fw-bold text-secondary fs-6 mb-3"><i class="fas fa-shield-alt me-1"></i> Bảo mật & Đổi mật khẩu</h5>
                    <p class="text-muted small mb-3">Chỉ nhập các ô bên dưới nếu bạn muốn thay đổi mật khẩu tài khoản (nếu không, hãy để trống).</p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Nhập mật khẩu hiện tại nếu muốn đổi mật khẩu">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mật khẩu mới</label>
                        <input type="password" name="password" class="form-control" placeholder="Ít nhất 6 ký tự" minlength="6">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Xác nhận mật khẩu mới</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới">
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-2">
                        <a href="{{ route('post.index') }}" class="text-decoration-none text-muted fw-semibold small">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại quản lý bài viết
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                            <i class="fas fa-save me-1"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection