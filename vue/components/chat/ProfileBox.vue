<template>
	<div class="portlet light chat-box-profile">
		<a v-if="auth.is_admin || auth.is_super" target="_blank" href="{{ website[0].url }}/user/{{ user.username }}">
			<img :src="user.avatar.url || '/img/default-photo.png'" style="width: 100%;" />
		</a>
		<img v-else :src="user.avatar.url || '/img/default-photo.png'" style="width: 100%;" />
		<div class="details">
			<h4 class="profile-desc-title">{{ user.real_name || user.username }}</h4>
			
			<div v-if="user.address" class="margin-top-10 profile-desc-link">
				City: <span class="info">{{ user.address }}</span>
			</div>
			<!-- <div class="margin-top-10 profile-desc-link">
				Looking for: <a href="#">{{ user.profile.looking_for }}</a>
			</div> -->
			<div v-if="user.about_me" class="margin-top-10 profile-desc-link">
				About me: <span class="info">{{ user.about_me }}</span>
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

	.info {
		font-weight: bold;
		color: #3590c1;
	}
</style>

<script>
	export default {
		props: {
			user: {
				type: Object,
				default() {
					return {}
				}
			}
		},

		data() {
			return {
				auth: {},
				website: null
			}
		},

		ready() {
			this.website = this.$parent.conversation.interlocutor.website;

			this.$http.get('auth').then(response => {
				this.auth = response.data
			})
		}
	}
</script>