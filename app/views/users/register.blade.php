@extends('layouts.logged-out')
@section('content')
    {{ Form::open(['url' => 'users/store']) }}
    <div>
        {{ $errors->first('general') }}
    </div>

    <div>
        {{ Form::label('username') }}
        {{ Form::email('username') }}
        {{ $errors->first('username') }}
    </div>

    <div>
        {{ Form::label('password') }}
        {{ Form::password('password') }}
        {{ $errors->first('password') }}

    </div>

    <div>
        {{ Form::label('first_name') }}
        {{ Form::text('profile[first_name]') }}
        {{ $errors->first('last_name') }}
    </div>

    <div>
        {{ Form::label('last_name') }}
        {{ Form::text('profile[last_name]') }}
        {{ $errors->first('last_name') }}
    </div>

    {{ Form::submit() }}
    {{ Form::close() }}
@stop