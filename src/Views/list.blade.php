@extends('webtoppings.ipwhitelisting.app')
@section('content')
    @if(isset($ip))
        <h3>{{ __('Edit IP Address') }}</h3>
        {!! Form::model($ip, ['route' => ['ipwhitelisting.update', $ip->id], 'method' => 'patch']) !!}
    @else
        <h3>{{ __('Add IP Address') }}</h3>
        {!! Form::open(['route' => 'ipwhitelisting.store']) !!}
    @endif
        <div class="form-inline">
            <div class="form-group">
                {!! Form::text('ip_address',isset($ip) ? old('ip_address',$ip->ip_address) : old('ip_address'),['class' => 'form-control','autocomplete'=>'off','placeholder'=>__('IP Address')]) !!}
                
            </div>
            <div class="form-group">
                {!! Form::select('status', array('1' => 'Active', '0' => 'Inactive'), isset($ip) ? old('status',$ip->status) : old('status'), ['class' => 'form-control']) !!}
                
            </div>
            <div class="form-group">
                {!! Form::submit($submit, ['class' => 'btn btn-primary form-control']) !!}
            </div>
        </div>
        <div class="form-inline">
            <div class="form-group">
                @if ($errors->has('ip_address'))
                    <small class="text-danger">{{ $errors->first('ip_address') }}</small>
                @endif
            </div>
            <div class="form-group">
                @if ($errors->has('status'))
                    <small class="text-danger">{{ $errors->first('status') }}</small>
                @endif
            </div>
            <div class="form-group">
            </div>
        </div>
    {!! Form::close() !!}
    <hr>
    <h4>{{ __('List') }}</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>{{ __('IP Address') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @if(count($ips) > 0)
                @foreach($ips as $ip)
                    <tr>
                        <td>{{ $ip->ip_address }}</td>
                        <td>{{ ($ip->status == 1) ? __('Active') : __('Inactive') }}</td>
                        <td>
                            {!! Form::open(['route' => ['ipwhitelisting.destroy', $ip->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    <a href="{!! route('ipwhitelisting.edit', [$ip->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="3">{{ __('No Data Found') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection