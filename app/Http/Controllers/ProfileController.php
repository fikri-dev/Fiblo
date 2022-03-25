<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('profiles.edit', [
            'user' => $user,
            'links' => $user->links
        ]);
    }

    public function update(ProfileRequest $request, User $user)
    {
        $user->update($request->all());
        if ($user->links) {
            $user->links()->update([
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'facebook' => $request->facebook,
            ]);
        } else {
            $user->links()->create([
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'facebook' => $request->facebook,
            ]);
        }
        return to_route('profiles.show', compact('user'))->with('message', 'Profil kamu berhasil diupdate :)');
    }

    public function follow(User $user)
    {
        $action = auth()->user()->wasFollow($user) ? 'unfollow' : 'follow';
        auth()->user()->wasFollow($user) ? auth()->user()->unfollow($user) : auth()->user()->follow($user);
        return back()->with('message', "Kamu berhasil $action @$user->username");
    }
}