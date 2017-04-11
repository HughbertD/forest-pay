{{ Form::open(['url' => '/api/v1/deposits', 'class' => 'form-horizontal']) }}

<div class="form-group" data-error="to_user">
    {{ Form::label('to_user', 'User to pay') }}
    {{ Form::email('to_user', Auth::user()->username, ['class' => 'form-control']) }}
</div>

<div class="form-group" data-error="amount">
    {{ Form::label('amount', 'Amount USD') }}
    {{ Form::text('amount', null, ['class' => 'form-control']) }}
</div>

<div class="form-group" data-error="from_user">
    {{ Form::label('from_user', 'From User') }}
    {{ Form::email('from_user', Auth::user()->username, ['class' => 'form-control']) }}
</div>

<div class="form-group" data-error="reference">
    {{ Form::label('reference', 'Paying in Reference') }}
    {{ Form::text('reference', null, ['class' => 'form-control']) }}
</div>

{{ Form::close() }}