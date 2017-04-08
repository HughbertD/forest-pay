@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="col col-lg-12">
            <div class="well-lg">
                <p>Hello {{ $user->profile->first_name }}</p>
            </div>
            <p>Lets do it</p>
        </div>
    </div>
@stop