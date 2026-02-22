<?php

namespace App\Http\Controllers;

use App\Models\DemoAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DemoAccountController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $this->requirePermission('admin.dashboard');

        $user = $request->user();
        if (!$user || !$user->isSuperAdmin()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'expires_at' => ['required', 'date', 'after:now'],
            'notes' => ['nullable', 'string'],
        ]);

        DemoAccount::create([
            'lab_id' => $user->lab_id,
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'expires_at' => $data['expires_at'],
            'notes' => $data['notes'] ?? null,
            'created_by' => $user->id,
        ]);

        return back()->with('demoAccountSuccess', 'Demo account created.');
    }
}
