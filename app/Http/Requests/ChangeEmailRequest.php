<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class ChangeEmailRequest extends FormRequest
{

    protected $redirect = '/account#account-section-2';

    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'correct_email',
            function ($attribute, $value, $parameters) {
                return \Auth::user()->email === $value;
            });

        $validationFactory->extend(
            'correct_new_email',
            function ($attribute, $value, $parameters) {
                return !User::email_exists($value);
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
            'old_email' => 'required|email|correct_email',
            'new_email' => 'required|email|confirmed|correct_new_email',
        ];
    }
}
