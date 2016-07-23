<template>
	<div class="row">
		<div class="col-md-3">
			<div class="scroller" style="height: 450px;" data-always-visible="1" data-rail-visible1="1">
				<ul class="ver-inline-menu tabbable margin-bottom-10">
					<li @click="viewConversation(conversation)" v-for="conversation in conversations">
						<a data-toggle="tab" href="#tab_1" aria-expanded="true">
						<i class="fa fa-user"></i> {{ conversation.initiator.username }} </a>
						<span class="after"></span>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-md-9">
			<chat-box :conversation="conversation"></chat-box>
		</div>
	</div>
</template>

<script>
	import ChatBox from './ChatBox.vue'

	export default {

		components: {
			ChatBox
		},

		props: {
			conversations: {
				type: Array,
				default() {
					return []
				}
			}
		},

		data() {
			return {
				conversation: {}
			}
		},

		methods: {
			viewConversation(conversation) {
				this.conversation = conversation;
			}
		}

	}
</script>