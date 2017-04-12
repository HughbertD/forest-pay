<div class="card">

    <div class="card-header">
        Pay a user
    </div>

    <div class="card-block">
        <h6 class="card-subtitle mb-2 text-muted">Search for the user below via their email</h6>
        {{ Form::open(['url' => '/api/v1/users/find', 'method' => 'GET', 'class' => 'form-horizontal', 'id' => 'userSearch', 'data-modal-title' => 'Pay User', 'data-modal-body' => '/pay']) }}
        <div class="form-group row" data-error="username">
            <div class="col-lg-10">
                {{ Form::email('username', null, ['class' => 'form-control', 'placeholder' => 'User to pay: john@example.net']) }}
            </div>
            <div class="col-lg-2">
                {{ Form::submit('Go', ['class' => 'btn btn-primary']) }}
            </div>
        </div>
        {{ Form::close() }}

    </div>
</div>