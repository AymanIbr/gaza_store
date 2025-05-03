<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

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
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);


        // PHPDoc Comment
        /** @var User $admin */
        $admin = Auth::user();

        $data = [
            'name' => $request->name
        ];

        if ($request->has('password')) {
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


    // Settings

    function settings()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings', compact('settings'));
    }

    function settings_save(Request $request)
    {
        $data = $request->except('_token', '_method', 'site_logo');
        if ($request->hasFile('site_logo')) {
            $data['site_logo'] = $request->file('site_logo')->store('uploads', 'custom');
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate([
                'key' => $key
            ], [
                'value' => $value
            ]);
        }
        flash()->success('Settings saved successfully');
        return redirect()->back();
    }

    function delete_logo()
    {
        Artisan::call('cache:clear');
        Setting::where('key', 'site_logo')->update([
            'value' => null
        ]);
    }


    // Notification

    function orders()
    {
        if (request()->has('id')) {
            $id = request()->id;
            Auth::user()->notifications->find($id)->MarkAsRead();
        }
        return 'order';
    }

    function notifications()
    {
        Auth::user()->notifications->markAsRead();
        return view('dashboard.notifications');
    }
}
