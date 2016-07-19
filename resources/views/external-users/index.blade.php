@extends('layouts.auth')

@section('page_title', 'User moderation')

@section('page_description', 'Manage users')

@section('stylesheets')
	<link rel="stylesheet" type="text/css" href="/css/sweetalert.css" />
@stop

@section('content')
	{!! Breadcrumbs::render('users') !!}

	<external-user-listings :users="{{ $users }}"></external-user-listings>
@stop
