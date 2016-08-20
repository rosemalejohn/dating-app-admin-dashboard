<template>
    <li v-if="conversations.length" class="dropdown dropdown-extended dropdown-inbox">
		<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
			<i class="icon-bell"></i>
			<span class="badge badge-danger">{{ conversations.length }}</span>
		</a>
		<ul class="dropdown-menu">
			<li class="external">
				<h3>New <span class="bold">{{ conversations.length }} flagged</span> conversations</h3>
			</li>
			<li>
				<ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
					<li v-for="conversation in conversations">
						<a href="/chat/{{ conversation.website_id }}/{{ conversation.conversation_id }}">
						<span class="photo">
							<img :src="conversation.user.photo || '/img/default-photo.png'" class="img-circle" alt="User photo">
						</span>
						<span class="subject">
							<span class="from">{{ conversation.user.name }}</span>
							<!-- <span class="time">{{ conversation.created_at | date 'relative' }}</span> -->
						</span>
						<span v-text="conversation.notes" class="message | str_limit 2"></span>
						</a>
					</li>
				</ul>
			</li>
		</ul>
	</li>
</template>

<script>
	export default {

		ready() {
			this.getFlaggedConversations();
		},

		data() {
			return {
				conversations: []
			}
		},

		methods: {
			getFlaggedConversations() {
				this.$http.get('conversations/flagged').then(response => {
					this.conversations = response.data;
				})
			}
		},

		events: {
			'conversation:flag'(conversation) {
				toastr.success('New conversation flagged.');
				this.getFlaggedConversations();
			},

			'conversation:unflagged'(conversation) {
				this.getFlaggedConversations();
			}
		}

	}
</script>