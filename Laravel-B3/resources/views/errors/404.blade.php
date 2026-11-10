@extends('layouts.app')
@section('title', 'Lỗi 404 - Không tìm thấy trang')
@section('content')
<div class="container py-5 text-center">
    <div class="py-5">
        <h1 class="display-1 fw-bold text-primary">404</h1>
        <h3 class="fw-bold mb-3">Oops! Không tìm thấy trang.</h3>
        <p class="text-muted mb-4">Trang bạn đang tìm kiếm có thể đã bị xóa, đổi tên hoặc không tồn tại.</p>
        <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">Về trang chủ</a>
    </div>
</div>
@endsection