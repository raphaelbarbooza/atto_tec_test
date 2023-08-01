@extends('layouts.auth')

@section('page-title',__('main.auth.login'))

@section('content')

    <div class="card box-shadow-01 border-0">
        <div class="card-body">

            <livewire:auth.login-box></livewire:auth.login-box>

        </div>
    </div>

@endsection
