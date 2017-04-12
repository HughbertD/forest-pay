<div class="card">

    <div class="card-header">
        Statement <i class="fa fa-question-circle" data-toggle="tooltip" title="All your transactions are here"></i>
    </div>

    <div class="card-block">

        @if (count($transactions) === 0)
            <h6 class="card-subtitle mb-2 text-muted">You haven't deposited or withdrawn any money yet</h6>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Type</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('d/m/y H:i') }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->event }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>