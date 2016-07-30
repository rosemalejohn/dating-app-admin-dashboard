@extends('_layouts.auth')

@section('page_title', 'Dashboard')

@section('stylesheets')
 	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@stop

@section('content')
    {!! Breadcrumbs::render('dashboard') !!}

    @if (auth()->user()->is_admin or auth()->user()->is_super)
		<message-graph :websites="{{ $websites }}"></message-graph>
	@endif
@stop

@section('scripts')
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
@stop
