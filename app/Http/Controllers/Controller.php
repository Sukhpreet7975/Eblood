<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function toggleStatus(){
        $user = auth()->user();
        $user->available =
        $user->available == 'yes' ? 'no' : 'yes';
        $user->save();

        return redirect('/profile')->with('success', 'Availability status updated!');
}
}
