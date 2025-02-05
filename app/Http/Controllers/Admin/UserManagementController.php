<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all(); 

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Remove todas as roles atuais e adiciona a nova
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users')->with('success', "Role de {$user->name} atualizada para {$request->role}");
    }
}
