<template>
	<div class="portlet light">
		<div class="portlet-body">
			<div class="table-container">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr role="row" class="heading">
							<th width="5%">
								Site
							</th> 
							<th width="40%">
								Member
							</th>
							<th width="40%">
								Moderated Profile
							</th>
							<th width="10%"></th>
						</tr>
						
						<tr v-for="conversation in conversations | filterBy search" role="row" class="filter">
							<td>
								<img width="100%" :src="conversation.interlocutor.website[0].logo || '/img/default-photo.png'" />
							</td>
							<td>{{ conversation.initiator.username}}</td>
							<td class="editable">{{ conversation.interlocutor.username }}</td>
							<td>
								<!-- chat/{website}/{conversation} -->
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

</template>

<script>
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
				search: ''
			}
		}

	}
</script>