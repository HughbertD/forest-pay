{{ Form::open(['url' => '/api/v1/users/pay', 'class' => 'form-horizontal']) }}
{{ Form::hidden('username', $user->username) }}

<div data-error="general"></div>

<div class="card" style="margin-bottom: 10px;">
    <div class="card-header">
        Pay User
    </div>

    <div class="card-block">
        <h6 class="card-title mb-2 text-muted"><?= $user->profile->full_name;?> (<?= $user->username;?>)</h6>
    </div>
</div>


<div class="form-group" data-error="amount">
    {{ Form::label('amount', 'Amount') }}
    {{ Form::text('amount', null, ['class' => 'form-control']) }}
</div>

<div class="form-group" data-error="reference">
    {{ Form::label('reference', 'Reference') }}
    {{ Form::text('reference', null, ['class' => 'form-control']) }}
</div>

{{ Form::close() }}