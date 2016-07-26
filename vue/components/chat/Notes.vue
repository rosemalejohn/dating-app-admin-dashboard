<template>
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">Profile notes</div>
		</div>
		<div class="portlet-body">
			<ul class="list-group">
				<li v-for="note in notes | filterBy filter in 'type'" class="list-group-item">
					<i @click="remove(note)" class="fa fa-remove hand-cursor"></i>
					<i @click="edit(note)" class="fa fa-edit hand-cursor"></i>&nbsp;
					{{ note.note }}
				</li>
			</ul>
		</div>
		<form @submit.prevent="submit()">
			<textarea v-model="noteText" class="form-control" placeholder="Add notes..."></textarea>
			<br />
			<button type="submit" class="btn btn-success btn-xs"><i class="fa fa-plus"></i>&nbsp;Add note</button>
		</form>
	</div>
</template>

<style lang="sass">
	.hand-cursor {
		cursor: pointer;
	}
</style>

<script>
	import Note from './../../stores/note'
	import swal from 'sweetalert'

	export default {

		props: {

			notes: {
				type: Array,
				default() {
					return []
				},
				twoWay: true
			},

			filter: {
				type: String,
				default: ''
			}
		},

		data() {
			return {
				noteText: ''
			}
		},

		methods: {
			submit() {
				Note.add(this.$parent.website, this.$parent.conversation, {
					note: this.noteText,
					type: this.filter
				}).then(response => {
					toastr.success('Note added!');
					this.notes.push(response.data);
					this.noteText = ''
				}).catch(error => {
					toastr.error('We cannot add the note.');
				})
			},

			remove(note) {
				swal({
					title: "Are you sure?",
					text: "You will not be able to recover this after deletion.",
					type: "warning",
					showCancelButton: true,
					showLoaderOnConfirm: true
				}, () => {
					Note.remove(note).then(response => {
						toastr.success(response.data);
						this.notes.$remove(note);
					}).catch(error => {
						toastr.error('Note cannot be deleted.')
					})
				});
			},
		}
	}
</script>