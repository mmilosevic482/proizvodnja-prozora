<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // Приказ профила - користи $request->user()
    public function show(Request $request)
    {
        $user = $request->user();
        return view('profile.show', compact('user'));
    }

    // Форма за уређивање
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('profile.edit', compact('user'));
    }

    // Ажурирање профила
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'telefon' => 'nullable|string|max:20',
            'adresa' => 'nullable|string|max:255',
            'grad' => 'nullable|string|max:100',
        ]);

        $user->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Профил је успешно ажуриран!');
    }
}
