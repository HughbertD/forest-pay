@extends('layouts.base')
@section('content')
    <div class="row" style="margin-bottom: 20px;">
        <div class="col col-lg-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Hello {{ $user->profile->first_name }}</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Current balance {{ $transactions->balance() }}</h6>
                    <h6>
                        <a href="/deposits/template/deposits.add" data-modal-get="/me" data-modal-get-container="document" data-modal="true" data-modal-title="Deposit money">
                            Deposit money
                        </a>
                    </h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom: 20px;">
        <div class="col col-lg-6">
            <div id="bankPod">
                @include('banks.index', ['banks' => $banks])
            </div>
        </div>

        <div class="col col-lg-6">
            <div class="row" style="margin-bottom: 20px;">
                <div class="col col-lg-12">
                    <div id="userPod">
                        @include('users.find')
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col col-lg-12">
                    <div id="withdrawPod">
                        @include('withdrawals.pod', ['banks' => $banks])
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="row">
        <div class="col col-lg-12">
            <div id="depositPod">
                @include('transactions.index', ['transactions' => $transactions])
            </div>
        </div>
    </div>
@stop