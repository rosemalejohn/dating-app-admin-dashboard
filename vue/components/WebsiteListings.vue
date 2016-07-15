<template>
	<div class="row">
		<div v-for="website in websites" class="col-md-3">
			<div class="portlet light profile-sidebar-portlet">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<img src="/img/default-photo.png" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						{{ website.name }}
					</div>
					<div class="profile-usertitle-job">
						{{ website.url }}
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class="profile-userbuttons">
					<button type="button" class="btn btn-circle green-haze btn-sm">Manage</button>
					<button @click="remove(website)" type="button" class="btn btn-circle btn-danger btn-sm">Remove</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {

		ready() {

		},

		data() {
			return {
				websites: [
					{
						id: 1,
						name: 'Twoo',
						url: 'https://twoo.com'
					}
				]
			}
		},

		methods: {
			remove(website) {
				this.websites.$remove(website);
			}
		}
		
	}
</script>