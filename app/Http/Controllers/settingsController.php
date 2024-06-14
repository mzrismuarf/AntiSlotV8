<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class settingsController extends Controller
{
    //
    public function index()
    {
        return view('dashboard.profile.settings');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
        }

        $user->password = Hash::make($request->password);
        // fix Undefined method 'save'.intelephense(1013)
        /** @var \App\Models\User $user */
        $user->save();

        return redirect()->back()->with('success', 'Password successfully updated!.');


        // return redirect()->route('dashboard')->with('status', 'Password successfully updated!');
    }
}
