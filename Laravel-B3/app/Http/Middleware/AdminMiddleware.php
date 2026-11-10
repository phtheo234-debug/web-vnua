<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu đã đăng nhập và role là admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Nếu không phải admin, chặn truy cập với lỗi 403
        abort(403, 'Bạn không có quyền truy cập khu vực quản trị viên!');
    }
}
