<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(): View
    {
        $members = User::query()
            ->where('role', UserRole::Member)
            ->with('profile')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.members.index', compact('members'));
    }
}
