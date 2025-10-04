<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function validatePassword(Request $request)
    {
        $request->validate([
            'admin_password' => 'required|string',
        ]);
        $user = Auth::user();
        if (\Hash::check($request->input('admin_password'), $user->password)) {
            return response()->json(['valid' => true]);
        } else {
            return response()->json(['valid' => false], 401);
        }
    }
    public function index()
    {
        // Only allow admin (by role)
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }
        $adminId = Auth::user()->id;
        $brokers = User::all()->sortByDesc(function($user) use ($adminId) {
            return $user->id == $adminId ? 1 : 0;
        });
        return view('admin.dashboard', compact('brokers'));
    }
    public function destroy($id)
    {
        // Only allow admin (by role)
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }
        $user = User::findOrFail($id);
        // Prevent admin from deleting themselves
        if ($user->id == Auth::user()->id) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Broker deleted successfully.');
    }

    public function updateRole(Request $request, $id)
    {
        // Only allow admin (by role)
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }
        $user = User::findOrFail($id);
        // Prevent admin from demoting themselves
        if ($user->id == Auth::user()->id) {
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'role' => 'required|in:User,Admin',
            'admin_password' => 'nullable|string',
        ]);
        // If role is being changed, require password
        if ($user->role !== $validated['role']) {
            if (empty($validated['admin_password'])) {
                return redirect()->back()->with('error', 'Password is required to change role.');
            }
            // Validate password for current admin
            if (!\Hash::check($validated['admin_password'], Auth::user()->password)) {
                return redirect()->back()->with('error', 'Incorrect password. Role not changed.');
            }
        }
        // Update name and email if provided
        if (!empty($validated['name'])) {
            $user->name = $validated['name'];
        }
        if (!empty($validated['email'])) {
            $user->email = $validated['email'];
        }
        $user->role = $validated['role'];
        $user->save();
        return redirect()->route('admin.dashboard')->with('success', 'Broker updated successfully.');
    }
}
