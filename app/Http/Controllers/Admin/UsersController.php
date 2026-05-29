<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        return app(AdminController::class)->manageUsers($request);
    }

    public function suspend($id)
    {
        return app(AdminController::class)->suspendUser($id);
    }

    public function toggleDonor($id)
    {
        return app(AdminController::class)->toggleDonorMode($id);
    }

    public function delete($id)
    {
        return app(AdminController::class)->deleteUser($id);
    }

    public function exportExcel()
    {
        return app(AdminController::class)->exportExcel();
    }

    public function exportPdf()
    {
        return app(AdminController::class)->exportPdf();
    }
}
