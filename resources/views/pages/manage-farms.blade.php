@extends('layouts.app')

@section('page-title',__('main.producers.detail_title'))

@section('header-block')

    <livewire:manage.producers.producer-info :producer-id="$producerId"></livewire:manage.producers.producer-info>

@endsection

@section('content')
    <div class="row flex-grow-1 mb-4">

        {{-- Manage the producer Farms --}}
        <div class="col-xl-2 ps-4 h-100">
            <livewire:manage.farms.farms-list :producer-id="$producerId"></livewire:manage.farms.farms-list>
        </div>
        <div class="col-xl-10 ps-0 pe-4 h-100">
            <livewire:manage.farms.farm-info></livewire:manage.farms.farm-info>
        </div>

    </div>

    {{-- Add the Producer Form Modal --}}
    <livewire:manage.producers.form-modal></livewire:manage.producers.form-modal>
@endsection
