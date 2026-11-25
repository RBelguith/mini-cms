<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function role(UpdateUserRoleRequest $request, User $user): RedirectResponse
    {
        $user->role = $request->validated('role');
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Rôle de '.$user->name.' mis à jour : '.$user->role.'.');
    }
}
