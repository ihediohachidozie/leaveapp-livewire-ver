<?php

namespace App\Actions\Fortify;

use App\Mail\UserActivationRequest;
use App\Models\User;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        //dd(request()->all());
        Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'staff_id' => ['required', 'numeric', 'unique:users'],
            'company_id' => ['required', 'numeric'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();
 

        $registeredUser = User::create([
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'email' => $input['email'],
            'username' => $input['username'],
            'staff_id' => $input['staff_id'],
            'company_id' => $input['company_id'],
            'password' => Hash::make($input['password']),
        ]);

        $users = User::where([
            ['company_id', $input['company_id']],
            ['role_id', 2]
        ])->pluck('email');

        if($users->count() > 0)
        {
            foreach($users as $user)
            {
                Mail::to($user)->queue(new UserActivationRequest($registeredUser));
    
            }
        }else{
            Mail::to('infotech@ecmterminals.com')->queue(new UserActivationRequest($registeredUser));
        }

        return $registeredUser;
    }
}
