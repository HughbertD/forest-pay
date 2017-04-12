@extends('layouts.logged-out')
@section('content')

    <div class="row">
        <div class="col col-lg-6 offset-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-subtitle">Login</h4>
                </div>
                <div class="card-block">
                    {{ Form::open(['url' => 'users/store']) }}
                    <div class="form-group">
                        {{ $errors->first('general') }}
                    </div>

                    <div class="form-group <?= $errors->has('username') ? 'has-danger' : '';?>">
                        {{ Form::label('Your email') }}
                        {{ Form::email('username', null, ['class' => 'form-control']) }}
                        {{ $errors->first('username', "<div class='form-control-feedback'>:message</div>") }}
                    </div>

                    <div class="form-group <?= $errors->has('password') ? 'has-danger' : '';?>">
                        {{ Form::label('password') }}
                        {{ Form::password('password', ['class' => 'form-control']) }}
                        {{ $errors->first('password', "<div class='form-control-feedback'>:message</div>") }}

                    </div>

                    <div class="form-group <?= $errors->has('first_name') ? 'has-danger' : '';?>">
                        {{ Form::label('first_name') }}
                        {{ Form::text('profile[first_name]', null, ['class' => 'form-control']) }}
                        {{ $errors->first('first_name', "<div class='form-control-feedback'>:message</div>") }}
                    </div>

                    <div class="form-group <?= $errors->has('last_name') ? 'has-danger' : '';?>">
                        {{ Form::label('last_name') }}
                        {{ Form::text('profile[last_name]', null, ['class' => 'form-control']) }}
                        {{ $errors->first('last_name', "<div class='form-control-feedback'>:message</div>") }}
                    </div>
                    {{ Form::submit('Register', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>

                <div class="card-footer">
                    <p class="card-text">Already have an account? Login <a href="/login">here</a></p>
                </div>
            </div>
        </div>
    </div>





@stop