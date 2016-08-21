@extends('_layouts.auth')

@section('page_title', 'Conversation box')

@section('page_description', 'This is the conversation box')

@section('stylesheets')
	<link href="/assets/pages/css/profile.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="/css/sweetalert.css" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/featherlight/1.5.0/featherlight.min.css" type="text/css" rel="stylesheet" />
@stop

@section('content')
	{!! Breadcrumbs::render('chat:conversation', $website, $conversation) !!}

	<conversation :website="{{ $website }}" :conversation="{{ $conversation }}"></conversation>
@stop

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/featherlight/1.5.0/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
@stop
