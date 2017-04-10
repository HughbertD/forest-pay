<?php $link = '<a href="/banks/template/banks.add" data-modal-get="/banks" data-modal-get-container="#bankPod" data-modal="true" data-modal-title="Add a new bank account">here</a>';?>

<div class="card">

    <div class="card-header">
            Banks Accounts <i class="fa fa-question-circle" data-toggle="tooltip" title="You can send money to Banks registered here"></i>
    </div>

    <div class="card-block">

        @if (count($banks) === 0)
            <h6 class="card-subtitle mb-2 text-muted">You have no banks set up, click {{ $link }} to do that now</h6>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Beneficiary</th>
                        <th>Bank Name</th>
                        <th>IBAN</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($banks as $bank)
                    <tr>
                        <td>{{ $bank->beneficiary_name }}</td>
                        <td>{{ $bank->bank_name }}</td>
                        <td>{{ $bank->iban }}</td>
                    </tr>
                 @endforeach
                </tbody>
            </table>

            <h6 class="card-subtitle mb-2 text-muted">
                Add another account {{ $link }}
            </h6>
        @endif

    </div>
</div>