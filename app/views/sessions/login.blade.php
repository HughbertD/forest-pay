@extends('layouts.logged-out')
@section('content')
<div class="row">
    <div class="col col-lg-6 offset-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-subtitle">Login</h4>
            </div>
            <div class="card-block">
                {{ Form::open(['url' => 'sessions/store', 'class' => 'form-horizontal']) }}
                <div class="form-group">
                    {{Form::label('username')}}
                    {{Form::email('username', null, ['class' => 'form-control', 'placeholder' => 'youremail@example.com'])}}
                </div>

                <div class="form-group">
                    {{Form::label('password')}}
                    {{Form::password('password', ['class' => 'form-control'])}}
                </div>
                {{Form::submit('Login', ['class' => 'btn btn-primary'])}}
                {{ Form::close() }}
            </div>

            <div class="card-footer">
                <p class="card-text">No account? Register <a href="/register">here</a></p>
            </div>
        </div>
    </div>
</div>
@stop