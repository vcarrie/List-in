<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;

class VerifyEmailController extends Controller
{
    public function index($id, $confirmation_code){
        if (\Auth::check()){
            $cec = new ChangeEmailController();
            $cec->confirm($id, $confirmation_code);
            return redirect('/account/emailSuccess');
        }
        else{
            $auth = new RegisterController();
            $auth->confirm($id, $confirmation_code);
            return redirect(route('login'))->with('confirmation-success', trans('confirmation::confirmation.success'));
        }
    }
}
