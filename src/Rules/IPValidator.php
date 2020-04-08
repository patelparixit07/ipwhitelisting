<?php

namespace WebToppings\IPWhitelisting\Rules;

use Illuminate\Contracts\Validation\Rule;

class IPValidator implements Rule
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
        $parts = explode('/', $value);
        if (count($parts) < 2) {
            $ip = $parts[0];
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
                return true;
            return false;
        } else if (count($parts) == 2) {
            $ip = $parts[0];
            $netmask = $parts[1];

            if (!preg_match("/^\d+$/", $netmask)) {
                return false;
            }

            $netmask = intval($parts[1]);
            
            if ($netmask < 0) {
                return false;
            }

            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                return $netmask <= 32;
            }

            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                return $netmask <= 128;
            }

            return false;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid IP Address or Range!';
    }
}
