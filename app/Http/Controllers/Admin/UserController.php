<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if (!Gate::allows('users')) {
        //     return abort(403, 'Don\'t have permission');
        // }
        $users = User::with('roles')->get();
        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if (!Gate::allows('create-user')) {
        //     return abort(403, 'Don\'t have permission');
        // }
        return view('dashboard.users.create', [
            'roles' => Role::all(),
            'user' => new User(),
            'user_role' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if (!Gate::allows('create-user')) {
        //     return abort(403, 'Don\'t have permission');
        // }
        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password')
        ]);

        $user->roles()->attach($request->roles);


        flash()->success('User created successfully!');
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // if (!Gate::allows('update-user')) {
        //     return abort(403, 'Don\'t have permission');
        // }
        $roles = Role::all();
        $user_role = $user->roles()->pluck('id')->toArray();
        return view('dashboard.users.edit', compact('user', 'roles', 'user_role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // if (!Gate::allows('update-user')) {
        //     return abort(403, 'Don\'t have permission');
        // }

        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->roles()->sync($request->roles);


        flash()->success('User updated successfully!');
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // if (!Gate::allows('delete-user')) {
        //     return abort(403, 'Don\'t have permission');
        // }
        User::destroy($id);

        flash()->success('User deleted successfully!');
        return redirect()->route('admin.users.index');
    }
}
