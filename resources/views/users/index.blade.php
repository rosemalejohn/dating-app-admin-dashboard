@extends('layouts.auth')

@section('page_title', 'Users')

@section('page_description', 'Manage users')

@section('content')
	{!! Breadcrumbs::render('users') !!}

	<user-listings></user-listings>
@stop
