<template>
	<div id="chat">
		<div class="portlet light">
			<div class="portlet-body">
				<div class="table-container">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr role="row" class="heading">
								<th width="5%">
									Site
								</th> 
								<th width="35%">
									Member
								</th>
								<th width="35%">
									Moderated Profile
								</th>
								<th width="20%">
									Message count
								</th>
								<th width="10%"></th>
							</tr>
							
							<tr v-if="!conversation.is_flagged || (conversation.is_flagged && (auth.is_super || auth.is_admin))" v-for="conversation in conversations | filterBy search" role="row" class="filter" :class="{'danger': conversation.is_flagged}">
								<td>
									<img width="100%" :src="conversation.interlocutor.website[0].logo || '/img/default-photo.png'" />
								</td>
								<td>{{ conversation.initiator.username}}</td>
								<td class="editable">{{ conversation.interlocutor.username }}</td>
								<td>{{ getInitiatorMessagesCount(conversation) }}</td>
								<td>
									<a href="/chat/{{ conversation.interlocutor.website[0].id }}/{{ conversation.id }}" class="btn btn-xs green filter-cancel"><i class="fa fa-comments-o"></i>&nbsp;Take chat</a>
								</td>
							</tr>
						</thead>
					</table>
					<div v-if="!conversations.length">
						<div class="note note-info note-bordered">
							<p>No chat listed.</p>
						</div>
					</div>
				</div>
				
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