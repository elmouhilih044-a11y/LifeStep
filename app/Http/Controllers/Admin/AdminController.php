<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\AdminService;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index()
    {
        $stats = $this->adminService->getDashboardStats();

        return view('admin.dashboard', $stats);
    }

    public function toggleBan(User $user)
    {
        $result = $this->adminService->toggleBan($user);

        return back()->with(
            $result['success'] ? 'success' : 'error',
            $result['message']
        );
    }
}