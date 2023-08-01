@extends('layouts.app')

@section('page-title',__('main.producers.title'))

@section('content')
<div class="row justify-content-center">

    {{-- Paginated Producers List --}}

    <div class="col-xl-10 col-md-12">
        <livewire:manage.producers-list></livewire:manage.producers-list>
    </div>

    {{-- Add the Producer Form Modal --}}
    <livewire:manage.producers.form-modal></livewire:manage.producers.form-modal>

</div>
@endsection
