<?php

namespace App\Http\Controllers;

use App\Belong;
use App\Comment;
use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Notifications\MailValidatorNotification;
use App\Rate;
use App\Repositories\ApiCdiscount\ApiCdiscountSearchByIdProductRepository;
use App\User;
use Bestmomo\LaravelEmailConfirmation\Notifications\ConfirmEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);

        return $user;
    }

    public function myAccount(ApiCdiscountSearchByIdProductRepository $api)
    {
        $user = Auth::user();

        $my_lists = $user->createdList()->get();
        $complete_lists = array();

        $to_return = array(
            $user,
        );
        foreach ($my_lists as $list) {
            $products = Belong::getProductsByIdList($list['id'], $api);
            $complete_lists[] = array($list, $products);

        }
        $to_return[] = $complete_lists;


        return view('account', compact('to_return'));
    }


    public function deleteUser($id)
    {

        $user = User::find($id);
        Rate::deleteRateByIdUser($id);
        Comment::deleteCommentByIdUser($id);

        $list = new ListController();

        foreach ($user->createdList as $lists) {
            $idList = $lists->id;
            $list->deleteList($idList);
        };

        $user->delete();

        return redirect("/admin");

    }

    public function updateUserPassword(ChangePasswordRequest $request)
    {
        $idUser = Auth::id();
        $user = User::find($idUser);
        $user->update(array('password' => Hash::make($request->new_pwd)));

        return redirect("/account#account-section-2")->with('confirmation-success-password', trans('confirmation.maj-password'));
    }

    public function updateUserEmail(ChangeEmailRequest $request)
    {
        $idUser = Auth::id();
        $user = User::find($idUser);

        $code = str_random(30);

        $user->email = $request->new_email;
        $user->confirmed = 0;
        $user->confirmation_code = $code;
        $user->save();
        $user->notify(new MailValidatorNotification());

        return redirect("/account#account-section-2")->with('confirmation-success-email', trans('confirmation::confirmation.resend'));
    }
}
