<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $admins = User::where('is_admin', true)->latest()->paginate(15);
        return view('admin.admins.index', compact('admins'));
    }

    public function create(): View
    {
        return view('admin.admins.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'is_admin' => true,
            'is_super_admin' => false,
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'تم إضافة المشرف بنجاح');
    }

    public function edit(User $admin): View
    {
        if ($admin->is_super_admin && $admin->id !== auth()->id()) {
            return redirect()->route('admin.admins.index')->with('error', 'لا يمكن تعديل مشرف رئيسي');
        }
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin): RedirectResponse
    {
        if ($admin->is_super_admin && $admin->id !== auth()->id()) {
            return redirect()->route('admin.admins.index')->with('error', 'لا يمكن تعديل مشرف رئيسي');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $admin->id],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')->with('success', 'تم تحديث بيانات المشرف بنجاح');
    }

    public function destroy(User $admin): RedirectResponse
    {
        if ($admin->is_super_admin) {
            return redirect()->route('admin.admins.index')->with('error', 'لا يمكن حذف مشرف رئيسي');
        }
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.admins.index')->with('error', 'لا يمكن حذف نفسك');
        }
        $admin->delete();
        return redirect()->route('admin.admins.index')->with('success', 'تم حذف المشرف بنجاح');
    }
}
