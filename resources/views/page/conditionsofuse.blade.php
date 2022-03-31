@extends('layout.default')

@section('title')
    <title>{{ __('page.title-conditionsofuse') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('common.faq') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('conditionsofuses') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('page.title-conditionsofuse') }}</span>
        </a>
    </li>
@endsection

@section('content')
     <div class="container box">
         <div class="col-md-12 page">
             <div class="header gradient silver">
                 <div class="inner_content">
                     <div class="page-title">
                         <h1>{{ __('page.title-conditionsofuse') }}</h1>
                     </div>
                 </div>
             </div>
             <article class="page-content">
                    Stran je še v izdelavi
             </article>
         </div>
     </div>
@endsection
