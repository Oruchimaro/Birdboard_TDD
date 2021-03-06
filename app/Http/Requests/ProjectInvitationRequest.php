<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ProjectInvitationRequest extends FormRequest
{
	/**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'invitations';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('manage', $this->route('project'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|exists:users,email'
        ];
    }


	public function messages()
	{
		return[
			'email.exists' => 'The user you are inviting must have a BirdBoard account.'
		];
	}
}


// public function rules()
// {
// 	return [
// 		'email' => [
// 			'required',
//			function ($attribute, $value, $fail) {
// 				if (! User::whereEmail($value)->exists() )
// 				{
// 					$fail('The user you are inviting must have a BirdBoard account');
// 				}
// 			}
// 		]
// 	];
// }
