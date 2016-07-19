@extends('layouts.auth')

@section('page_title', 'Websites')

@section('page_description', 'Manage websites')

@section('stylesheets')
	<link href="/assets/pages/css/profile.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="/css/sweetalert.css" />
@stop

@section('content')
	{!! Breadcrumbs::render('websites') !!}

	<website-listings :websites="{{ $websites }}"></website-listings>
@stop
