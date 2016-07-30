@extends('_layouts.auth')

@section('page_title', 'Change password')

@section('content')
	{!! Breadcrumbs::render('users:account', $user) !!}

	<account :user="{{ $user }}"></account>
@stop
