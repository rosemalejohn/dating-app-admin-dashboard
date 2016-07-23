@extends('_layouts.auth')

@section('page_title', 'Website users')

@section('page_description', 'Manage website users')

@section('stylesheets')
	<link rel="stylesheet" type="text/css" href="/css/sweetalert.css" />
@stop

@section('content')
	{!! Breadcrumbs::render('websites:users', $website) !!}

	<managed-user-listings :website="{{ $website }}"></managed-user-listings>
@stop
