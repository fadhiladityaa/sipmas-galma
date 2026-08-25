<?php

namespace App\Http\Controllers;

// use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
// use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Rt;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

public function edit(Request $request)
{
    $user = $request->user();
    $rts = Rt::where('is_active', true)->get(); // Ambil semua RT aktif
    
    return view('profile.edit', [
        'user' => $user,
        'rts' => $rts,
    ]);
}

public function update(Request $request)
{
    $user = $request->user();

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        'nik' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
        'tempat_lahir' => ['nullable', 'string', 'max:100'],
        'tanggal_lahir' => ['nullable', 'date'],
        'jenis_kelamin' => ['nullable', 'in:L,P'],
        'alamat' => ['nullable', 'string', 'max:500'],
        'agama' => ['nullable', 'string', 'max:50'],
        'pekerjaan' => ['nullable', 'string', 'max:100'],
        'nomor_hp' => ['nullable', 'string', 'max:20'],
        'rt_id' => ['nullable', 'exists:rts,id'], // tambahkan validasi RT
        'ktp' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        'kk' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
    ]);

    $user->fill($validated);

    // Upload KTP
    if ($request->hasFile('ktp')) {
        if ($user->ktp_path && Storage::disk('public')->exists($user->ktp_path)) {
            Storage::disk('public')->delete($user->ktp_path);
        }
        $path = $request->file('ktp')->store('ktp', 'public');
        $user->ktp_path = $path;
    }

    // Upload KK
    if ($request->hasFile('kk')) {
        if ($user->kk_path && Storage::disk('public')->exists($user->kk_path)) {
            Storage::disk('public')->delete($user->kk_path);
        }
        $path = $request->file('kk')->store('kk', 'public');
        $user->kk_path = $path;
    }

    $user->save();

    return redirect()->route('profile.edit')->with('status', 'profile-updated');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
