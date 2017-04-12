<?php $link = '<a href="/withdrawals/to_bank" data-modal-get="/me" data-modal-get-container="document" data-modal="true" data-modal-title="Withdraw money">here</a>'?>
<?php $newBank = '<a href="/banks/template/banks.add" data-modal-get="/banks" data-modal-get-container="#bankPod" data-modal="true" data-modal-title="Add a new bank account">here</a>'?>


<div class="card">
    <div class="card-header">
        Withdraw money to a bank account <i class="fa fa-question-circle" data-toggle="tooltip" title="You can send money to Banks registered here"></i>
    </div>


    <div class="card-block">
        @if (count($banks) === 0)
            <h6 class="card-subtitle mb-2 text-muted">You have no banks set up, click {{ $newBank }} to do that now</h6>
        @else
            <p class="card-text">Click {{ $link }} to withdraw wallet funds to your bank account</p>
        @endif
    </div>
</div>