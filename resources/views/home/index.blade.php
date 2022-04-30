@extends('layout.default')

@section('content')
    <div class="container-fluid">
        @include('blocks.ad_head')
        @include('blocks.news')
        @include('blocks.poll')
        @include('blocks.recommended')
        @include('blocks.ad_right')

        <!--@include('blocks.featured')-->
        @include('blocks.torrents_torrents')
        @include('blocks.ad')
        @include('blocks.tops_torrents')
        <!--@include('blocks.top_torrents')-->
        <!--@include('blocks.top_uploaders')-->
        @include('blocks.latest_topics')
        @include('blocks.latest_posts')
        @include('blocks.online')
        @include('blocks.notification')
    </div>
@endsection
