@extends('_layouts.auth')

@section('page_title', 'System Users')

@section('page_description', 'Manage system users')

@section('stylesheets')
	<link rel="stylesheet" type="text/css" href="/css/sweetalert.css" />
@stop

@section('content')
	{!! Breadcrumbs::render('users') !!}

	<user-listings :users="{{ $users }}"></user-listings>
@stop
