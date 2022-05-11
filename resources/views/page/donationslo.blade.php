@extends('layout.default')

@section('title')
    <title>{{ __('page.title-donation') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('common.donations') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('donationslos') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ config('other.title') }}
                {{ __('common.donation') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="container box">
        <div class="header gradient silver">
            <div class="inner_content">
                <div class="page-title">
                    <h1>{{ __('page.title-donation') }}</h1>
                </div>
            </div>
        </div>
            <div class="row black-list">
                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="text-center black-item">
                            <h4>5€</h4>
                            <form action="https://www.paypal.com/donate" method="post" target="_top">
                            <input type="hidden" name="hosted_button_id" value="9VSKWN3QQJCQU" target="_black" />
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="Donacija 5€" />
                            </form>
                            <i class="fal fa-euro-sign text-green black-icon"></i>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="text-center black-item">
                            <h4>10€</h4>
                            <form action="https://www.paypal.com/donate" method="post" target="_top">
                            <input type="hidden" name="hosted_button_id" value="RP96883WS92ZJ" target="_black" />
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="Donacija 10€" />
                            </form>
                            <i class="fal fa-euro-sign text-green black-icon"></i>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="text-center black-item">
                            <h4>15€</h4>
                            <form action="https://www.paypal.com/donate" method="post" target="_top">
                            <input type="hidden" name="hosted_button_id" value="VTBES36PDSMWJ" target="_black" />
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="Donacija 15€" />
                            </form>
                            <i class="fal fa-euro-sign text-green black-icon"></i>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="text-center black-item">
                            <h4>20€</h4>
                            <form action="https://www.paypal.com/donate" method="post" target="_top">
                            <input type="hidden" name="hosted_button_id" value="9ZSEYX2SXHQPC" target="_black" />
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="Donacija 20€" />
                            </form>
                            <i class="fal fa-euro-sign text-green black-icon"></i>
                        </div>
                    </div>

            </div>
        </div>
    </div>
@endsection
