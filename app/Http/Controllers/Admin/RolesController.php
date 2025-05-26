<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleAbility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('roles')) {
            return abort(403, 'Don\'t have permission to access this page');
        }

        $roles = Role::paginate(5);
        return view('dashboard.roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create-role')) {
            return abort(403, 'Don\'t have permission to access this page');
        }
        return view('dashboard.roles.create', [
            'role' => new Role()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create-role')) {
            return abort(403, 'Don\'t have permission to access this page');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'required|array',
        ]);

        $role = Role::createWithAbilities($request);

        flash()->success('Role created successfully!');
        return redirect()->route('admin.roles.index');
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
    public function edit(Role $role)
    {
        if (Gate::denies('update-role')) {
            return abort(403, 'Don\'t have permission to access this page');
        }

                                                    // key , value
        $role_abilities = $role->abilities()->pluck('type', 'ability')->toArray();
        return view('dashboard.roles.edit', compact('role', 'role_abilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if (Gate::denies('update-role')) {
            return abort(403, 'Don\'t have permission to access this page');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'required|array',
        ]);

        $role->updateWithAbilities($request);

        flash()->success('Role updated successfully!');
        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('delete-role')) {
            return abort(403, 'Don\'t have permission to access this page');
        }
        Role::destroy($id);

        flash()->success('Role deleted successfully!');
        return redirect()->route('admin.roles.index');
    }
}
