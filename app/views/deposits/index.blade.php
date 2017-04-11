<?php $link = '<a href="/deposits/template/deposits.add" data-modal-get="/deposits" data-modal-get-container="#depositPod" data-modal="true" data-modal-title="Deposit money">here</a>';?>

<div class="card">

    <div class="card-header">
            Recent Deposits <i class="fa fa-question-circle" data-toggle="tooltip" title="You can add more money to your wallet here (if only life was this easy!)"></i>
    </div>

    <div class="card-block">

        @if (count($deposits) === 0)
            <h6 class="card-subtitle mb-2 text-muted">There are currently no deposits made to this account, click {{ $link }} to add one now</h6>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>From User</th>
                        <th>Reference</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($deposits as $deposit)
                    <tr>
                        <td>{{ $deposit->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $deposit->amount }}</td>
                        <td>{{ $deposit->getData('from_user') }}</td>
                        <td>{{ $deposit->getData('reference') }}</td>
                    </tr>
                 @endforeach
                </tbody>
            </table>

            <h6 class="card-subtitle mb-2 text-muted">
                Add another deposit {{ $link }}
            </h6>
        @endif

    </div>
</div>