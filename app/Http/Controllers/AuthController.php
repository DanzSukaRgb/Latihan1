<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\VerifyEmail;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Cari user terlebih dahulu untuk pengecekan verifikasi
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.'
            ])->withInput();
        }

        // Periksa verifikasi email
        if (!$user->hasVerifiedEmail()) {
            return back()->withErrors([
                'email' => 'Anda perlu memverifikasi email terlebih dahulu sebelum login. Silakan cek email Anda.'
            ])->withInput();
        }

        // Coba login
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Verifikasi email
    public function verifyEmail($token)
    {
        try {
            $user = User::where('email_verification_token', $token)->first();

            if (!$user) {
                return redirect('/login')->with('error', 'Link verifikasi tidak valid atau sudah kadaluarsa.');
            }

            // Periksa apakah email sudah diverifikasi sebelumnya
            if ($user->hasVerifiedEmail()) {
                return redirect('/login')->with('info', 'Email Anda sudah diverifikasi sebelumnya. Silakan login.');
            }

            // Verifikasi email
            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $saved = $user->save();

            if (!$saved) {
                throw new \Exception('Gagal menyimpan status verifikasi');
            }

            // Login otomatis setelah verifikasi
            Auth::login($user);

            return redirect('/dashboard')
                ->with('verified', true)
                ->with('success', 'Email berhasil diverifikasi! Selamat datang.');
        } catch (\Exception $e) {
            return redirect('/login')
                ->with('error', 'Terjadi kesalahan saat memverifikasi email. Silakan coba lagi.');
        }
    }

    // Menampilkan form registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'email_verification_token' => Str::random(60),
        ]);

        // Kirim email verifikasi
        try {
            Mail::to($user->email)->send(new VerifyEmail($user));
        } catch (\Exception $e) {
            // Tangani error tanpa logging
        }

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi.');
    }

    // Menampilkan form lupa password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Proses pengiriman link reset password
    public function sendResetPasswordLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Buat token reset dan simpan
        $token = Str::random(60);
        $user->update([
            'password_reset_token' => $token,
            'password_reset_expires_at' => now()->addHour(),
        ]);

        // Kirim email reset
        try {
            Mail::to($user->email)->send(new ResetPassword($user, $token));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email reset password. Silakan coba lagi.');
        }

        return redirect()->route('login')->with('success', 'Link reset password telah dikirim ke email Anda.');
    }

    // Menampilkan form reset password
    public function showResetPasswordForm($token)
    {
        $user = User::where('password_reset_token', $token)
                    ->where('password_reset_expires_at', '>', now())
                    ->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Link reset password tidak valid atau sudah kedaluwarsa.');
        }

        return view('auth.reset-password', compact('token'));
    }

    // Proses reset password
    public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::where('password_reset_token', $token)
                    ->where('password_reset_expires_at', '>', now())
                    ->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Link reset password tidak valid atau sudah kedaluwarsa.');
        }

        $user->update([
            'password' => Hash::make($request->password),
            'password_reset_token' => null,
            'password_reset_expires_at' => null,
        ]);

        // Login otomatis setelah reset
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Kata sandi berhasil direset! Selamat datang kembali.');
    }

    // Menampilkan form ganti kata sandi
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    // Proses ganti kata sandi
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Verifikasi kata sandi lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi lama salah.',
            ])->withInput();
        }

        // Update kata sandi
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Kirim notifikasi email
        try {
            Mail::raw('Kata sandi Anda telah diubah pada ' . now() . '. Jika ini bukan Anda, segera hubungi admin.', function ($message) use ($user) {
                $message->to($user->email)->subject('Notifikasi Perubahan Kata Sandi');
            });
        } catch (\Exception $e) {
            // Tangani error tanpa logging
        }

        return redirect()->route('dashboard')->with('success', 'Kata sandi berhasil diubah.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}