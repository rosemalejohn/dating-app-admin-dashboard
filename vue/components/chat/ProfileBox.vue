<template>
	<div class="portlet light chat-box-profile">
		<img :src="profile.avatar.url || '/img/default-photo.png'" style="width: 100%;" />
		<div class="details">
			<h4 class="profile-desc-title">{{ profile.username }}</h4>
			
			<div v-if="profile.profile.address != ''" class="margin-top-10 profile-desc-link">
				City: <a href="javascipt:;">{{ profile.profile.address }}</a>
			</div>
			<div class="margin-top-10 profile-desc-link">
				Looking for: <a href="#">Male</a>
			</div>
			<div class="margin-top-10 profile-desc-link">
				Description: <a href="#">{{ profile.about_me }}</a>
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