<?php

namespace WebToppings\IPWhitelisting\Helpers;

use WebToppings\IPWhitelisting\IPWhitelisting;

class IPAddress
{
    /**
     * Create a new model instance.
     *
     * @param  IPWhitelisting  $ipAddresses
     * @return void
     */
    public function __construct()
    {
        //
    }

   /**
     * Check if users IP address is valid or not 
     *
     * @param  ip
     * @return boolean true if the IP is valid / false if not.
     */
    public static function isWhitelisted($ip)
    {
        $data = IPWhitelisting::getData();
        $whitelistIP = $data->pluck('ip_address')->toArray();
        $matchedIP = '';

        if (in_array($ip, $whitelistIP)) {
            $matchedIP = $ip;
        } else {
            foreach ($whitelistIP as $wip) {
                if (self::ipInRange($ip, $wip)) {
                    $matchedIP = $wip;
                }
            }
        }

        if (!empty($matchedIP))
            return true;

        return false;
    }

    /**
     * Check if a given IP is in a network
     *
     * @param  string $ip    IP to check in IPV4 format eg. 127.0.0.1
     * @param  string $range IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
     * @return boolean true if the ip is in this range / false if not.
     */
    protected static function ipInRange($ip, $range)
    {
        if (strpos($range, '/') == false) {
            $range .= '/32';
        }
        // $range is in IP/CIDR format eg 127.0.0.1/24
        list( $range, $netmask ) = explode('/', $range, 2);
        $rangeDecimal = ip2long($range);
        $IPDecimal = ip2long($ip);
        $wildcardDecimal = pow(2, ( 32 - $netmask)) - 1;
        $netmaskDecimal = ~ $wildcardDecimal;
        return ( ( $IPDecimal & $netmaskDecimal ) == ( $rangeDecimal & $netmaskDecimal ) );
    }
}