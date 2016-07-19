<template>
	<div class="row">
		<div v-if="!websites.length" class="col-md-12">
			<div class="note note-info note-bordered">
				<p>No websites listed.</p>
			</div>
		</div>
		<div v-for="website in websites" class="col-md-3">
			<div class="portlet light profile-sidebar-portlet">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<a href="/websites/{{ website.id }}">
						<img :src="website.logo || '/img/default-photo.png'" class="img-responsive" alt="">
					</a>
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						{{ website.name }}
					</div>
					<div class="profile-usertitle-job">
						<a href="{{ website.url }}" target="_blank">{{ website.url }}</a>
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class="profile-userbuttons">
					<a href="/websites/{{ website.id }}" class="btn btn-circle green-haze btn-sm">Manage</a>
					<a href="/websites/{{ website.id }}/users" class="btn btn-circle btn-primary btn-sm">Users</a>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import swal from 'sweetalert'
	import Website from './../stores/website'
	
	export default {

		props: {

			websites: {
				type: Array,
				default() {
					return []
				}
			}

		},

		methods: {

			remove(website) {
				swal({
					title: "Are you sure?",
					text: "You will not be able to recover this after deletion.",
					type: "warning",
					showCancelButton: true,
					showLoaderOnConfirm: true
				}, () => {
					Website.delete(website).then(response => {
						toastr.success(response.data);
						this.websites.$remove(website);
					});
				});
			}
		},

		events: {
			'website:created'(website) {
				this.websites.push(website);
			}
		}
		
	}
</script>