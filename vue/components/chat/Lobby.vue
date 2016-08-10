<template>
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption caption-md font-red-sunglo">
				<i class="icon-bar-chart theme-font hide"></i>
				<span class="caption-subject theme-font bold uppercase">Member Activity</span>
				<span class="caption-helper">user listings</span>
			</div>
		</div>
		<div class="portlet-body">
			<div class="table-scrollable table-scrollable-borderless">
				<table class="table table-hover table-light">
					<thead>
						<tr class="uppercase">
							<th>
								Site
							</th>
							<th width="30%">
								 Member
							</th>
							<th width="30%">
								 Moderated Profile
							</th>
							<th>
								Messages
							</th>
							<th width="10%">
								
							</th>
						</tr>
					</thead>
					<tr :class="{'danger': conversation.is_flagged}" v-if="!conversation.is_flagged || (conversation.is_flagged && (auth.is_super || auth.is_admin))" v-for="conversation in conversations">
						<td>
							<img class="user-pic" :src="conversation.interlocutor.website[0].logo || '/img/default-photo.png'">
						</td>
						<td> 
							{{ conversation.initiator.username}}
						</td>
						<td>
							{{ conversation.interlocutor.username }}
						</td>
						<td>
							{{ conversation.messages_count }}
						</td>
						<td>
							<a href="/chat/{{ conversation.interlocutor.website[0].id }}/{{ conversation.id }}" class="btn btn-xs green filter-cancel"><i class="fa fa-comments-o"></i>&nbsp;Take chat</a>
						</td>
					</tr>
					<div v-if="!users.length" class="alert alert-block alert-danger fade in">
						<button type="button" class="close" data-dismiss="alert"></button>
						<h4 class="alert-heading"><strong>Important!</strong></h4>
						<p>No users listed.</p>
					</div>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
	import _ from 'underscore'
	import Conversation from './Conversation.vue'

	export default {

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
				search: '',
				auth: {}
			}
		},

		ready() {
			this.$http.get('auth').then(response => {
				this.auth = response.data;
			})
		},

		methods: {
			getInitiatorMessagesCount(conversation) {
				return _.filter(conversation.messages, (message) => {
					return message.senderId == conversation.initiator.id;
				}).length;
			}
		},

		events: {
			'conversation:remove'(conversation) {
				this.conversations = _.reject(this.conversations, (item) => {
					return item.id == conversation.id
				});
			},

			'conversation:flag'(conversation) {
				var conversation = _.find(this.conversations, (item) => {
					return item.id == conversation.id
				});
				conversation.is_flagged = true;
			},

			'conversation:push'(conversation) {
				console.log(conversation);
				var conversation = this.conversations.push(conversation);
			}
		}

	}
</script>