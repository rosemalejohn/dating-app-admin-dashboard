<template>
	<div class="portlet light ">
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-share font-blue-steel hide"></i>
				<span class="caption-subject font-blue-steel bold">Profile notes</span>
			</div>
		</div>
		<div class="portlet-body">
			<div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
				<ul class="feeds">
					<li>
						<div class="col1">
							<div class="cont">
								<div class="cont-col1">
									<div class="label label-sm label-warning">
										<i class="fa fa-bell-o"></i>
									</div>
								</div>
								<div class="cont-col2">
									<div class="desc">
										 Web server hardware needs to be upgraded. <span class="label label-sm label-default ">
										Overdue </span>
									</div>
								</div>
							</div>
						</div>
						<div class="col2">
							<div class="date">
								 2 hours
							</div>
						</div>
					</li>
					<li>
						<a href="javascript:;">
						<div class="col1">
							<div class="cont">
								<div class="cont-col1">
									<div class="label label-sm label-info">
										<i class="fa fa-briefcase"></i>
									</div>
								</div>
								<div class="cont-col2">
									<div class="desc">
										 IPO Report for year 2013 has been released.
									</div>
								</div>
							</div>
						</div>
						<div class="col2">
							<div class="date">
								 20 mins
							</div>
						</div>
						</a>
					</li>
				</ul>
			</div>
			<div class="scroller-footer">
				<textarea class="form-control" placeholder="Add notes..."></textarea>
			</div>
		</div>
	</div>
</template>

<style lang="sass">
	
</style>

<script>
	export default {

		props: {
			notes: {
				type: Array,
				default() {
					return []
				}
			}
		},

		methods: {
			submit(task) {

			}
		}
	}
</script>