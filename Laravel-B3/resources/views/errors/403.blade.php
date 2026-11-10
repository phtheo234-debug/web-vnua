@extends('layouts.app')
@section('title', 'Lỗi 403 - Không có quyền truy cập')
@section('content')
<div class="container py-5 text-center">
    <div class="py-5">
        <h1 class="display-1 fw-bold text-warning">403</h1>
        <h3 class="fw-bold mb-3">Truy cập bị từ chối!</h3>
        <p class="text-muted mb-4">Bạn không có quyền hạn để truy cập khu vực hoặc thực hiện hành động này.</p>
        <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">Về trang chủ</a>
    </div>
</div>
@endsection