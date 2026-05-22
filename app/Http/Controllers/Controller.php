<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function toggleStatus()
    {
        $user = auth()->user();
        $user->available = $user->available == 'yes' ? 'no' : 'yes';
        $user->save();

        return redirect('/profile')->with('success', 'Availability status updated!');
    }
}
