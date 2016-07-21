@extends('layouts.auth')

@section('page_title', 'Dashboard')

@section('content')
    {!! Breadcrumbs::render('dashboard') !!}

    @if (auth()->user()->is_admin)
	    <div class="row">
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<a class="dashboard-stat dashboard-stat-light blue-soft" href="/websites">
				<div class="visual">
					<i class="fa fa-globe"></i>
				</div>
				<div class="details">
					<div class="number">
						{{ App\Website::count() }}
					</div>
					<div class="desc">
						Websites
					</div>
				</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<a class="dashboard-stat dashboard-stat-light red-soft" href="/users">
				<div class="visual">
					<i class="fa fa-user"></i>
				</div>
				<div class="details">
					<div class="number">
						{{ App\User::count() }}
					</div>
					<div class="desc">
						Users
					</div>
				</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<a class="dashboard-stat dashboard-stat-light green-soft" href="javascript:;">
				<div class="visual">
					<i class="fa fa-shopping-cart"></i>
				</div>
				<div class="details">
					<div class="number">
						 549
					</div>
					<div class="desc">
						 New Orders
					</div>
				</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<a class="dashboard-stat dashboard-stat-light purple-soft" href="javascript:;">
				<div class="visual">
					<i class="fa fa-globe"></i>
				</div>
				<div class="details">
					<div class="number">
						 +89%
					</div>
					<div class="desc">
						 Brand Popularity
					</div>
				</div>
				</a>
			</div>
		</div>
	@endif
@stop
