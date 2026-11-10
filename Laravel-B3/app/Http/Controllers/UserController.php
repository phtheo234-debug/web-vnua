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

    // Form quên mật khẩu
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Cấp lại mật khẩu
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

        // Tạo mật khẩu ngẫu nhiên
        $newPassword = Str::random(6);//6 ký tự
        $user->password = Hash::make($newPassword);
        $user->save();

        // Ghi log thời gian đổi/cấp lại mật khẩu
        Log::info('password reset success', [
            'email' => $user->email,
            'time' => now(),
        ]);

        // Gửi email chứa mật khẩu mới
        Mail::raw("Xin chào {$user->name},\n\nMật khẩu mới của bạn là: {$newPassword}\n\nVui lòng đăng nhập lại và đổi mật khẩu mới.", function ($message) use ($user) {
            $message->to($user->email)->subject('Cấp lại mật khẩu mới');
        });

        return back()->with('message', 'Mật khẩu mới đã được gửi về email của bạn!');
    }
    //Form đổi mật khẩu
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    // Cập nhật thông tin cá nhân và mật khẩu
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:password',
            'password'         => 'nullable|string|min:6|confirmed',
        ], [
            'name.required'                 => 'Vui lòng nhập họ tên.',
            'email.required'                => 'Vui lòng nhập địa chỉ email.',
            'email.email'                   => 'Email không đúng định dạng.',
            'email.unique'                  => 'Email này đã được sử dụng bởi tài khoản khác.',
            'current_password.required_with' => 'Vui lòng nhập mật khẩu hiện tại để đổi mật khẩu.',
            'password.min'                  => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'password.confirmed'            => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.'])->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Ghi log sự kiện cập nhật tài khoản thành công
        Log::info('profile update success', [
            'user' => $user->email,
            'time' => now(),
        ]);

        return back()->with('message', 'Cập nhật thông tin tài khoản thành công!');
    }
}