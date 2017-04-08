@extends('layouts.logged-out')
@section('content')
{{ Form::open(['url' => 'sessions/store']) }}
<div>
    {{Form::label('username')}}
    {{Form::email('username')}}
</div>

<div>
    {{Form::label('password')}}
    {{Form::password('password')}}
</div>

{{Form::submit()}}
{{ Form::close() }}
@stop