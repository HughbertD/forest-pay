{{ Form::open(['url' => '/api/v1/banks', 'class' => 'form-horizontal']) }}

<div class="form-group" data-error="name">
    {{ Form::label('name', 'Name') }}
    {{ Form::text('name', null, ['class' => 'form-control']) }}
</div>

<div class="form-group" data-error="bank_name">
    {{ Form::label('bank_name', 'Bank Name') }}
    {{ Form::text('bank_name', null, ['class' => 'form-control']) }}
</div>

<div class="form-group" data-error="iban">
    {{ Form::label('IBAN') }}
    {{ Form::text('iban', null, ['class' => 'form-control']) }}
</div>

<div class="form-group" data-error="beneficiary_name">
    {{ Form::label('Beneficiary Name') }}
    {{ Form::text('beneficiary_name', null, ['class' => 'form-control']) }}
</div>

{{ Form::close() }}