<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RequestService;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
    public function __construct(protected RequestService $requestService)
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        return app(AdminController::class)->requests($request);
    }

    public function show($id)
    {
        return app(AdminController::class)->showRequest($id);
    }

    public function updateStatus(Request $request, $id)
    {
        return app(AdminController::class)->updateRequestStatus($request, $id);
    }
}
