<?php

namespace App\Rules;

use App\Http\Controllers\UsersController;
use Illuminate\Contracts\Validation\Rule;

class ValidEmail implements Rule
{
    private $usersController;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->usersController = new UsersController();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!empty($value)){
            $user = $this->usersController->getUserWithEmail($value);
            if ($user->count() == 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Account with this email already exists.';
    }
}
