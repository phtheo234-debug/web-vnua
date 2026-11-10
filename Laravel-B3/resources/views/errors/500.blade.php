@extends('layouts.app')
@section('title', 'Lỗi 500 - Lỗi máy chủ nội bộ')
@section('content')
<div class="container py-5 text-center">
    <div class="py-5">
        <h1 class="display-1 fw-bold text-danger">500</h1>
        <h3 class="fw-bold mb-3">Đã xảy ra lỗi hệ thống!</h3>
        <p class="text-muted mb-4">Máy chủ đang gặp sự cố kỹ thuật. Vui lòng quay lại sau ít phút.</p>
        <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">Về trang chủ</a>
    </div>
</div>
@endsection