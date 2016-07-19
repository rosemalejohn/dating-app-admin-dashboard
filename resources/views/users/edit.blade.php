@extends('layouts.auth')

@section('page_title', $user->name)

@section('page_description', 'Edit user profile')

@section('content')
	{!! Breadcrumbs::render('users:edit', $user) !!}

	<user-profile-edit :user="{{ $user }}"></user-profile-edit>
@stop
