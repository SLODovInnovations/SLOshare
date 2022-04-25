@extends('layout.default')

@section('title')
    <title>{{ __('page.title-donations') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('common.donations') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('donationsslo') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ config('other.title') }}
                {{ __('common.donations') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="container box">
        <div class="col-md-12 page">
            <div class="alert alert-info" id="alert1">
                <div class="text-center">
                    <span>
                    </span>
                </div>
            </div>
            <div class="row black-list">
                <h2>}</h2>
                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="text-center black-item">
                            <h4>{{ $client }}</h4>
                            <span></span>
                            <i class="fal fa-ban text-red black-icon"></i>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
