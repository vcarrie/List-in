<?php

namespace App\Http\Controllers;

class ChangeEmailController extends Controller
{
    public function confirm($id, $confirmation_code)
    {
        $model = config('auth.providers.users.model');

        $user = $model::whereId($id)->whereConfirmationCode($confirmation_code)->firstOrFail();

        $user->confirmation_code = null;
        $user->confirmed = true;
        $user->save();
    }

    public function successChangeEmail(){
        return view('successAccount');
    }
}
