<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\WelcomeEmail;

class UserController extends Controller
{
    // Form đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/^\S*$/',
                'confirmed',
            ],
        ], [
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.regex' => 'Mật khẩu không được chứa khoảng trắng.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);
        $request->session()->regenerate();

        // Ghi log đăng ký thành công kèm thời gian
        Log::info('register success', [
            'user' => auth()->user(),
            'time' => now(),
        ]);

        Mail::to($user->email)->send(new WelcomeEmail($user));

        return redirect()->route('post.index')
            ->with('message', 'Đăng ký tài khoản thành công, đã gửi email chào mừng!');
    }

    // Form đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'min:6',
                'regex:/^\S*$/',
            ],
        ], [
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.regex' => 'Mật khẩu không được chứa khoảng trắng.',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            // Ghi log đăng nhập thành công kèm thời gian
            Log::info('login success', [
                'user' => auth()->user(),
                'time' => now(),
            ]);

            Log::critical('daily check info', [
                'user' => auth()->user(),
            ]);

            return redirect()->intended('/post')
                ->with('message', 'Đăng nhập thành công!');
        }

        // Ghi log đăng nhập thất bại
        Log::warning('login failed', [
            'email' => $request->email,
            'time' => now(),
        ]);

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        // Ghi log trước khi đăng xuất kèm thời gian
        Log::info('logout', [
            'user' => auth()->user(),
            'time' => now(),
        ]);

        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('message', 'Đã đăng xuất thành công!');
    }

    // Hiển thị form quên mật khẩu
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Cấp lại mật khẩu mới qua email
    public function sendResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không đúng định dạng.'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email không tồn tại trong hệ thống!');
        }

        // Tạo mật khẩu ngẫu nhiên mới
        $newPassword = Str::random(6);
        $user->password = Hash::make($newPassword);
        $user->save();

        // Ghi log thời gian đổi/cấp lại mật khẩu
        Log::info('password reset success', [
            'email' => $user->email,
            'time' => now(),
        ]);

        // Gửi email chứa mật khẩu mới cho người dùng
        Mail::raw("Xin chào {$user->name},\n\nMật khẩu mới của bạn là: {$newPassword}\n\nVui lòng đăng nhập lại và đổi mật khẩu mới.", function ($message) use ($user) {
            $message->to($user->email)->subject('Cấp lại mật khẩu mới');
        });

        return back()->with('message', 'Mật khẩu mới đã được gửi về email của bạn!');
    }
    // Hiển thị form đổi mật khẩu
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    // Cập nhật mật khẩu mới
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        $user = auth()->user();

        // Kiểm tra mật khẩu hiện tại có đúng không
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        // Cập nhật mật khẩu
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Ghi log thời gian đổi mật khẩu
        Log::info('password change success', [
            'user' => $user->email,
            'time' => now(),
        ]);

        return back()->with('message', 'Đổi mật khẩu thành công!');
    }
}