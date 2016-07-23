@extends('_layouts.auth')

@section('page_title', 'Messages')

@section('page_description', 'Manage chat system')

@section('stylesheets')
	<link href="/assets/pages/css/profile.css" rel="stylesheet" type="text/css"/>
@stop

@section('content')
	{!! Breadcrumbs::render('messages') !!}

	<conversations :conversations="{{ $conversations }}"></conversations>

@stop
