<?php

namespace WebToppings\IPWhitelisting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IPWhitelisting extends Model
{
    use SoftDeletes;

    protected $table = 'ip_whitelisting';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ip_address',
        'status'
    ];

    /**
     * Get IP Adresses from database
     *
     * @return Eloquent object
     */
    protected function getData()
    {
        return IPWhitelisting::where(['status' => 1])->select('ip_address')->get();
    }
}
