<template>
	<div class="portlet light chat-box-profile">
		<img :src="profile.avatar.url || '/img/default-photo.png'" style="width: 100%;" />
		<div class="details">
			<h4 class="profile-desc-title">{{ profile.username }}</h4>
			<span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
			
			<div v-if="profile.profile.address != ''" class="margin-top-20 profile-desc-link">
				<i class="fa fa-map-marker"></i>
				<a href="javascipt:;">{{ profile.profile.address }}</a>
			</div>
			<div class="margin-top-20 profile-desc-link">
				<i class="fa fa-search"></i>
				<a href="#">Male</a>
			</div>
		</div>
	</div>
</template>

<style lang="sass">
	.chat-box-profile {
		padding: 0px !important;
		.details {
			padding: 20px;
		}
	}
</style>

<script>
	export default {
		props: {
			profile: {
				type: Object,
				default() {
					return {}
				}
			}
		}
	}
</script>