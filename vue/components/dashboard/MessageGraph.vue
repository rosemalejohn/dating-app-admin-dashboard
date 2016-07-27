<template>
	<div class="portlet light">
		<div class="portlet-title tabbable-line">
			<div class="caption">
				<i class="fa fa-usd font-green-sharp"></i>
				<span class="caption-subject font-green-sharp bold uppercase">Messages</span>
			</div>
			<ul class="nav nav-tabs">
				<li @click="showData(website)" v-for="website in websites" :class="{active: $index == 0}">
					<a href="#website-{{ website.id }}" data-toggle="tab">
					{{ website.name }} </a>
				</li>
			</ul>
		</div>
		<div class="portlet-body">
			<div class="tab-content">
				<div v-for="website in websites" class="tab-pane" :class="{active: $index == 0}" id="website-{{ website.id }}">
					<div id="message-graph" style="height: 300px;"></div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

	export default {

		props: {
			websites: {
				type: Array,
				default() {
					return []
				}
			}
		},

		ready() {
			var data = {
				label: "Time",
				data: [[2010, 1], [2010, 5], [2016, 13]]
			}
           	var plot = $("#message-graph").plot(data).data("plot");
            
		},

		methods: {
			showData(website) {
				console.info('Website: ' + website.name)
			}
		}

	}
</script>