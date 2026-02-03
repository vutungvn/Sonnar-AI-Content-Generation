<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $verificationCode = random_int(100000, 999999);

            session(['verification_code' => $verificationCode, 'user_id' => $user->id, 'code_expires_at' => now()->addMinutes(10)]);
            Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

            Auth::logout();

            return redirect()->route('custom.verification.form')->with('status', 'Verification code sent to your email.');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials provided!']);
    }

    public function showVerification()
    {
        return view('auth.verify');
    }

    public function verificationVerify(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        if (!session('code_expires_at') || now()->gt(session('code_expires_at'))) {
            return redirect()->back()->withErrors(['code' => 'Verification code has expired!']);
        }

        if ($request->code == session('verification_code')) {
            Auth::loginUsingId(session('user_id'));

            session()->forget(['verification_code', 'user_id', 'code_expires_at']);
            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->withErrors(['code' => 'Invalid Verification Code!']);
    }

    public function resendVerificationCode()
    {
        if (
            session('code_expires_at') &&
            now()->isBefore(session('code_expires_at'))
        ) {
            $secondsLeft = (int) ceil(
                now()->diffInSeconds(session('code_expires_at'), false)
            );

            return redirect()->back()->withErrors([
                'resend' => "Please wait {$secondsLeft} seconds before requesting a new code."
            ]);
        }


        $verificationCode = random_int(100000, 999999);
        session(['verification_code' => $verificationCode, 'code_expires_at' => now()->addMinutes(10)]);
        $user = User::find(session('user_id'));
        Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

        return redirect()->back()->with('status', 'New verification code sent to your email.');
    }

    public function showProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile', compact('profileData'));
    }

    public function profileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        $oldPhotoPath = $data->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/user_images'), $filename);
            $data->photo = $filename;

            if ($oldPhotoPath && $oldPhotoPath !== $filename) {
                $this->deleteOldPhoto($oldPhotoPath);
            }
        }

        $data->save();

        return redirect()->back();
    }

    private function deleteOldPhoto(string $oldPhotoPath)
    {
        $fullPath = public_path('upload/user_images/' . $oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
