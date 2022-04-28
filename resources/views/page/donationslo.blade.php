@extends('layout.default')

@section('title')
    <title>{{ __('page.title-donations') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('common.donations') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('donationslos') }}" itemprop="url" class="l-breadcrumb-item-link">
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
                <h2>5€</h2>
                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="text-center black-item">
                            <h4></h4>
                            <span>
                            <form action="https://www.paypal.com/donate" method="post" target="_top">
                            <input type="hidden" name="hosted_button_id" value="9VSKWN3QQJCQU" />
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
                            </form>
                            </span>
                            <i class="fa fa-eur text-red black-icon"></i>
                        </div>
                    </div>
            </div>

            <div class="row black-list">
                <h2>10€</h2>
                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="text-center black-item">
                            <h4></h4>
                            <span>
<div id="donate-button-container">
<div id="donate-button"></div>
<script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
<script>
PayPal.Donation.Button({
env:'production',
hosted_button_id:'RP96883WS92ZJ',
image: {
src:'https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif',
alt:'Donate with PayPal button',
title:'PayPal - The safer, easier way to pay online!',
}
}).render('#donate-button');
</script>
</div>

                            </span>
                            <i class="fa fa-eur text-red black-icon"></i>
                        </div>
                    </div>
            </div>

        </div>
    </div>
@endsection
