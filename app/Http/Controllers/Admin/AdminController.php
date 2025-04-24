<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    function index()
    {
        return view('dashboard.index');
    }


    public function profile()
    {
        $admin = Auth::user();
        return view('dashboard.profile', compact('admin'));
    }

    public function profile_save(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,svg,jpeg',
            'current_password' => ['required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);


        // PHPDoc Comment
        /** @var User $admin */
        $admin = Auth::user();

        $data = [
            'name' => $request->name
        ];

        if($request->has('password')){
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        if ($request->hasFile('image')) {
            if ($admin->image) {
                File::delete('storage/' . $admin->image->path);
                $admin->image()->delete();
            }
            $path = $request->file('image')->store('uploads', 'custom');
            $admin->image()->create([
                'path' => $path
            ]);
        }


        return redirect()->back();
    }

    function check_password(Request $request)
    {
        return Hash::check($request->password, Auth::user()->password);
    }
}
