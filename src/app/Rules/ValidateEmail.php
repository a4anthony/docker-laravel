<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        //rule to validate gmail and yahoo email formats
        $email = $value; //$value = 'test@gmail.com'
        $split_email_1 = explode('@', $email); //explode string at "@"
        $split_email_2 = explode('.', $split_email_1[1]); //explode string domain at "."
        //if email contains 'gmail.com'
        if (($split_email_2[0] == 'gmail') && ($split_email_2[1] == 'com')) {
            return (($split_email_2[0] == 'gmail') && ($split_email_2[1] == 'com'));
        }
        //if email contains 'yahoo.com'
        elseif (($split_email_2[0] == 'yahoo') && ($split_email_2[1] == 'com')) {
            return (($split_email_2[0] == 'yahoo') && ($split_email_2[1] == 'com'));
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute format is invalid.';
    }
}
