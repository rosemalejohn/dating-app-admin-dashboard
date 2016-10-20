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
				<table class="table table-light">
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
							<th>
								Notes
							</th>
							<th width="10%">
								
							</th>
						</tr>
					</thead>
					<tr :class="{
						'danger': conversation.is_flagged, 
						'info': conversation.returning_conversation && conversation.returning_conversation.status == 1,
						'success': conversation.returning_conversation && conversation.returning_conversation.status == 2,
						'warning': conversation.returning_conversation && conversation.returning_conversation.status == 3}" 
						v-if="!conversation.is_flagged || (conversation.is_flagged && ($root.auth.is_super || $root.auth.is_admin))" 
						v-for="conversation in conversations" 
						track-by="id">
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
							{{ conversation.flagged ? conversation.flagged.notes : '' }}
						</td>
						<td>
							<a href="/chat/{{ conversation.interlocutor.website[0].id }}/{{ conversation.id }}" class="btn btn-xs green filter-cancel"><i class="fa fa-comments-o"></i>&nbsp;Take chat</a>

							<button v-if="authUser.is_admin || authUser.is_super" @click="deleteConversation(conversation)" class="btn btn-xs red"><i class="fa fa-remove"></i>&nbsp;Delete</button>
						</td>
					</tr>
				</table>
				<div v-if="!conversations.length" class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert"></button>
					<h4 class="alert-heading"><strong>Important!</strong></h4>
					<p>No conversations listed.</p>
				</div>
			</div>
		</div>
	</div>
</template>

<style lang="sass">
	tr {
		&.info,
		&.danger,
		&.warning,
		&.success,
		&.day, 
		&.three-days,
		&.two-weeks {
			td {
				color: white !important;
				font-weight: bolder !important;
			}
		}
		&.day {
			td {
				background-color: yellow;
			}
		}
		&.three-days {
			td {
				background-color: yellow;
			}
		}
		&.two-weeks {
			td {
				background-color: yellow;
			}
		}
	}
</style>

<script>
	import _ from 'underscore'
	import Conversation from './Conversation.vue'
	import ConversationService from './../../api/conversation'
	import swal from 'sweetalert'

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
				authUser: false
			}
		},

		ready() {

			this.$http.get('auth').then(response => {
				this.authUser = response.data;
			})

			setInterval(() => {
				console.log('Fetching conversations...');
				this.getConversations();
			}, 10000);

		},	

		methods: {
			getInitiatorMessagesCount(conversation) {
				return _.filter(conversation.messages, (message) => {
					return message.senderId == conversation.initiator.id;
				}).length;
			},

			getConversations() {
				this.$http.get('chat').then(response => {
					this.conversations = response.data;
				})
			},

			deleteConversation(conversation) {
				swal({
					title: "Are you sure?",
					text: "This conversation will be removed in the chat lobby.",
					type: "warning",
					showCancelButton: true,
					showLoaderOnConfirm: true
				}, () => {
					ConversationService.removeConversation(conversation.interlocutor.website[0].id, conversation.id).then(response => {
						this.conversations.$remove(conversation);
					}).catch(err => {
						toastr.error('Cannot delete conversation!');
					});
				});
			}
		},

		events: {
			'conversation:remove'(conversation) {
				this.conversations = _.reject(this.conversations, (item) => {
					return item.id == conversation.id;
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