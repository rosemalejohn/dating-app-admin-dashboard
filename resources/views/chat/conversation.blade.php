@extends('_layouts.auth')

@section('page_title', 'Conversation box')

@section('page_description', 'This is the conversation box')

@section('stylesheets')
	<link href="/assets/pages/css/profile.css" rel="stylesheet" type="text/css"/>
@stop


@section('content')
	{!! Breadcrumbs::render('chat:conversation', $website, $conversation) !!}

	<conversation :website="{{ $website }}" :conversation="{{ $conversation }}"></conversation>
@stop
