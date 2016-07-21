@extends('layouts.auth')

@section('page_title', 'Messages')

@section('page_description', 'Manage chat system')

@section('content')
	{!! Breadcrumbs::render('messages') !!}

	<div class="row">
		<div class="col-md-3">
			<div class="scroller" style="height: 353px;" data-always-visible="1" data-rail-visible1="1">
				<ul class="ver-inline-menu tabbable margin-bottom-10">
					<li class="active">
						<a data-toggle="tab" href="#tab_1" aria-expanded="true">
						<i class="fa fa-briefcase"></i> Ricky Martin </a>
						<span class="after">
						</span>
					</li>
					<li class="">
						<a data-toggle="tab" href="#tab_2" aria-expanded="false">
						<i class="fa fa-group"></i> John Doe </a>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-md-9">
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-bubble font-red-sunglo"></i>
						<span class="caption-subject font-red-sunglo bold uppercase">Chats</span>
					</div>
					<div class="inputs">
						<div class="portlet-input input-inline input-small">
							<div class="input-icon right">
								<i class="icon-magnifier"></i>
								<input type="text" class="form-control input-circle" placeholder="Search message...">
							</div>
						</div>
					</div>
				</div>
				<div class="portlet-body" id="chats">
					<div class="scroller" style="height: 353px;" data-always-visible="1" data-rail-visible1="1">
						<ul class="chats">
							<li class="in">
								<img class="avatar" alt="" src="../../assets/admin/layout2/img/avatar1.jpg"/>
								<div class="message">
									<span class="arrow">
									</span>
									<a href="javascript:;" class="name">
									Bob Nilson </a>
									<span class="datetime">
									at 20:09 </span>
									<span class="body">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
								</div>
							</li>
							<li class="out">
								<img class="avatar" alt="" src="../../assets/admin/layout2/img/avatar2.jpg"/>
								<div class="message">
									<span class="arrow">
									</span>
									<a href="javascript:;" class="name">
									Lisa Wong </a>
									<span class="datetime">
									at 20:11 </span>
									<span class="body">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
								</div>
							</li>
							<li class="in">
								<img class="avatar" alt="" src="../../assets/admin/layout2/img/avatar1.jpg"/>
								<div class="message">
									<span class="arrow">
									</span>
									<a href="javascript:;" class="name">
									Bob Nilson </a>
									<span class="datetime">
									at 20:30 </span>
									<span class="body">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
								</div>
							</li>
							<li class="out">
								<img class="avatar" alt="" src="../../assets/admin/layout2/img/avatar3.jpg"/>
								<div class="message">
									<span class="arrow">
									</span>
									<a href="javascript:;" class="name">
									Richard Doe </a>
									<span class="datetime">
									at 20:33 </span>
									<span class="body">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
								</div>
							</li>
							<li class="in">
								<img class="avatar" alt="" src="../../assets/admin/layout2/img/avatar3.jpg"/>
								<div class="message">
									<span class="arrow">
									</span>
									<a href="javascript:;" class="name">
									Richard Doe </a>
									<span class="datetime">
									at 20:35 </span>
									<span class="body">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
								</div>
							</li>
							<li class="out">
								<img class="avatar" alt="" src="../../assets/admin/layout2/img/avatar1.jpg"/>
								<div class="message">
									<span class="arrow">
									</span>
									<a href="javascript:;" class="name">
									Bob Nilson </a>
									<span class="datetime">
									at 20:40 </span>
									<span class="body">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
								</div>
							</li>
						</ul>
					</div>
					<div class="chat-form">
						<div class="input-cont">
							<input class="form-control" type="text" placeholder="Press enter to send..."/>
						</div>
						<div class="btn-cont">
							<span class="arrow">
							</span>
							<a href="" class="btn blue icn-only">
								<i class="fa fa-arrow-right icon-white"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop
