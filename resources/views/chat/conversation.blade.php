@extends('_layouts.auth')

@section('page_title', 'Conversation box')

@section('page_description', 'This is the conversation box')

@section('stylesheets')
	<link href="/assets/pages/css/profile.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="/css/sweetalert.css" />
@stop

@section('content')
	{!! Breadcrumbs::render('chat:conversation', $website, $conversation) !!}

	<conversation :website="{{ $website }}" :conversation="{{ $conversation }}"></conversation>
@stop

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js" type="text/javascript"></script>
@stop
