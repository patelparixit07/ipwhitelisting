<?php

namespace WebToppings\IPWhitelisting;

use App\Http\Controllers\Controller;
use Request;
use WebToppings\IPWhitelisting\IPWhitelisting;
use WebToppings\IPWhitelisting\Rules\IPValidator;

class IPWhitelistingController extends Controller
{
    public function index()
    {
        return redirect()->route('ipwhitelisting.create');
    }

    public function create()
    {
        $ips = IPWhitelisting::all();
        $submit = 'Add';
        return view('webtoppings.ipwhitelisting.list', compact('ips', 'submit'));
    }

    public function store()
    {
        Request::validate([
            'ip_address' => ['required','unique:ip_whitelisting,ip_address,NULL,id,deleted_at,NULL',new IPValidator() ]
        ],[
            'ip_address.unique' => 'Ip address has already been added',
        ]);

        $input = Request::all();
        IPWhitelisting::create($input);
        return redirect()->route('ipwhitelisting.create');
    }

    public function edit($id)
    {
        $ips = IPWhitelisting::all();
        $ip = $ips->find($id);
        $submit = 'Update';
        return view('webtoppings.ipwhitelisting.list', compact('ips', 'ip', 'submit'));
    }

    public function update($id)
    {
        $input = Request::all();
        $ip = IPWhitelisting::findOrFail($id);
        Request::validate([
            'ip_address' => ['required','unique:ip_whitelisting,ip_address,'.$ip->id.',id,deleted_at,NULL',new IPValidator() ]
        ],[
            'ip_address.unique' => 'Ip address has already been added',
        ]);
        $ip->update($input);
        return redirect()->route('ipwhitelisting.create');
    }

    public function destroy($id)
    {
        $ip = IPWhitelisting::findOrFail($id);
        $ip->delete();
        return redirect()->route('ipwhitelisting.create');
    }
}
