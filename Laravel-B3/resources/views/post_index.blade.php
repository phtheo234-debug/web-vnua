@extends('layouts.app')

@section('title', 'Quản lý bài viết')

@section('content')
<div class="container py-4">

    <h2 class="mb-3">Quản lý bài viết</h2>

    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <a href="{{ route('post.create') }}" class="btn btn-primary mb-3">
        + Thêm bài viết
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Danh mục</th>
                    <th>Tác giả</th>
                    <th>Ngày đăng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>

                        <td>
                            @if($post->image)
                                <img src="{{ asset($post->image) }}"
                                     alt="{{ $post->title }}"
                                     width="80">
                            @endif
                        </td>

                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category }}</td>
                        <td>{{ $post->author }}</td>
                        <td>{{ $post->post_date }}</td>

                        <td>
                            <a href="{{ route('post.edit', $post->id) }}"
                               class="btn btn-warning btn-sm">
                                Sửa
                            </a>

                            <form action="{{ route('post.destroy', $post->id) }}"
                                  method="POST"
                                  style="display:inline"
                                  onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            Chưa có bài viết nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
