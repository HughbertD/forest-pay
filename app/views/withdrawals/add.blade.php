{{ Form::open(['url' => '/api/v1/withdrawals/to_bank', 'class' => 'form-horizontal']) }}

<div class="form-group" data-error="bank_id">
    {{ Form::label('bank_id', 'Bank to pay to') }}
    {{ Form::select('bank_id', $bankList, null, ['class' => 'form-control']) }}
</div>

<div class="form-group" data-error="amount">
    {{ Form::label('amount', 'Amount USD') }}
    {{ Form::text('amount', null, ['class' => 'form-control']) }}
</div>

{{ Form::close() }}