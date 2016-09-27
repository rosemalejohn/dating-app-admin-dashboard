@extends('_layouts.auth')

@section('page_title', 'Affiliates')

@section('stylesheets')

@stop

@section('content')
	{!! Breadcrumbs::render('affiliate:users') !!}

	<affiliate-team-listings :affiliates="{{ $affiliates }}"></affiliate-team-listings>
@stop
