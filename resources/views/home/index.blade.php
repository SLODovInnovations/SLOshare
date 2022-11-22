@extends('layout.default')

@section('content')
	<div class="sidebar2 sidebar--inverse">
        @include('blocks.stats')
        @include('blocks.poll')
        @include('blocks.ad_right')
		
        @include('blocks.ad_head')
        @include('blocks.recommended')
        @include('blocks.video')
		
		@include('blocks.news')
	</div>

        <!--@include('blocks.featured')-->
	<div class="sidebar2 sidebar--inverse">
		@include('blocks.torrents_torrents')
        @include('blocks.tops_torrents')
		@include('blocks.ad_left')
	</div>
        @include('blocks.online')
        @include('blocks.notification')
    <div class="page__home">

        <!--@include('blocks.top_torrents')-->
        <!--@include('blocks.top_uploaders')-->
        <!--@include('blocks.latest_topics')-->
        <!--@include('blocks.latest_posts')-->

    </div>
@endsection