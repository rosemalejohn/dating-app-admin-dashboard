<template>
	<div class="row">
		<div v-for="stat in stats" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<a class="dashboard-stat dashboard-stat-light {{ stat.color }}-soft" href="{{ stat.link }}">
			<div class="visual">
				<i class="{{ stat.icon }}"></i>
			</div>
			<div class="details">
				<div class="number">
					{{ stat.count }}
				</div>
				<div class="desc">
					{{ stat.name }}
				</div>
			</div>
			</a>
		</div>
	</div>
	<div class="portlet light">
		<div class="portlet-title tabbable-line">
			<div class="caption">
				<span class="caption-subject font-green-sharp bold uppercase">Messages analytics</span>
				<span class="caption-helper">&nbsp;last 30 days</span>
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
					<div v-if="!data.length && !fetching" class="alert alert-info">No messages for this month.</div>
					<div id="message-graph-{{ website.id }}" style="height: 300px;"></div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

	import _ from 'underscore'
	import Spinner from './../../spin.js'
	import moment from 'moment'

	export default {

		props: {
			websites: {
				type: Array,
				default() {
					return []
				}
			}
		},

		data() {

			return {
				data: [],
				fetching: false,
				stats: []
			}

		},

		ready() {
			this.showData(this.websites[0]);

			this.$http.get('stats').then(response => {
				this.stats = response.data;
			})
		},

		methods: {
			showData(website) {
				if (!this.fetching) {
					this.fetching = true;
					this.$http.get('stats/' + website.id + '/messages').then(response => {
						var dates = [];

						for (var i = 30; i > 1; i--) {
							dates.push(moment().subtract(i, 'days'));
						}
						console.log(response.data);
						this.data = _.map(dates, (date) => {
							date = moment(date);
							return {
								date: date.format('MMM D'), 
								value: _.filter(response.data, (group, key) => {
									return key == date.format('MMM-DD-YYYY')
								}).length
							}
						});

						$('#message-graph-' + website.id).empty();

						Morris.Bar({
							element: 'message-graph-' + website.id,
							data: this.data,
							xkey: 'date',
							// A list of names of data record attributes that contain y-values.
							ykeys: ['value'],
							ymax: 10,
							// Labels for the ykeys -- will be displayed when you hover over the
							// chart.
							labels: ['Messages'],
							yLabelFormat: (y) => {
								return Math.round(y);
							}
						})
						this.fetching = false;
					}).catch(err => {
						toastr.error('We cannot fetch analytics.');
						this.fetching = false;
					})
				}
				
			}
		},

		watch: {
			fetching(val) {
				this.$nextTick(() => {
					if (val) {
						Spinner.spin();
					} else {
						Spinner.stop();
					}
				});
			}
		}

	}
</script>