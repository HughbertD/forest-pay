@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="col col-lg-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Hello {{ $user->profile->first_name }}</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Current balance {{ $transactions->balance() }}</h6>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col col-lg-6">
            <div id="bankPod">
                @include('banks.index', ['banks' => $banks])
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col col-lg-12">
            <div id="depositPod">
                @include('deposits.index', ['deposits' => $deposits])
            </div>
        </div>
    </div>
@stop