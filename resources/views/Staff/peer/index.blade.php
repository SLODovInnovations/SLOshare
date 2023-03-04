@extends('layout.default')

@section('title')
    <title>Peers</title>
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('staff.dashboard.index') }}" class="breadcrumb__link">
            {{ __('staff.staff-dashboard') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        Peers
    </li>
@endsection

@section('page', 'page__peers--index')

@section('content')
    @livewire('peer-search')
@endsection
