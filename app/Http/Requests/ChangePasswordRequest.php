<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Factory as ValidationFactory;

class ChangePasswordRequest extends FormRequest
{
    protected $redirect = '/account#account-section-2';

    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'correct_password',
            function ($attribute, $value, $parameters) {

                $idUser = Auth::id();
                $user = User::find($idUser);

                if (Hash::check($value, $user->password)) {
                    return true;
                }

                return false;
            });
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_pwd' => 'required|string|min:6|correct_password',
            'new_pwd' => 'required|string|min:6|confirmed',
        ];
    }
}
