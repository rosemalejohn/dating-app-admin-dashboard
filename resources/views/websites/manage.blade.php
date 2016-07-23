@extends('_layouts.auth')

@section('page_title', $website->name)

@section('page_description', 'Manage website')

@section('stylesheets')
	<link href="/assets/pages/css/profile.css" rel="stylesheet" type="text/css"/>
@stop

@section('content')
	{!! Breadcrumbs::render('websites:manage', $website) !!}

	<manage-website :website="{{ $website }}"></manage-website>
@stop
