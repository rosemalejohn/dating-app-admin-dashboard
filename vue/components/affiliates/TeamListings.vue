<template>
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption caption-md font-red-sunglo">
				<i class="icon-bar-chart theme-font hide"></i>
				<span class="caption-subject theme-font bold uppercase">Teams</span>
			</div>
			<div class="actions">
				<div class="inputs">
					<div class="portlet-input input-inline input-small">
						<div class="input-icon right">
							<i class="icon-magnifier"></i>
							<input v-model="search" type="text" class="form-control input-circle" placeholder="search...">
						</div>
					</div>
					<div class="btn-group btn-group-devided">
						<a href="/affiliates/new" class="btn btn-transparent grey-salsa btn-circle btn-sm active">Add new affiliate</a>
					</div>
				</div>
			</div>
		</div>
		<div class="portlet-body">
			<div class="table-scrollable table-scrollable-borderless">
				<table class="table table-hover table-light">
					<thead>
						<tr class="uppercase">
							<th>
								
							</th>
							<th>
							 	Name
							</th>
							<th>
						 		Contact
							</th>
							<th>
							 	Company
							</th>
							<th>
								Online
							</th>
							<th>Domains</th>
							<th>Opt in</th>
							<th>Start date</th>
						</tr>
					</thead>
					<tr v-for="affiliate in affiliates | filterBy search">
						<td>

						</td>
						<td>
							{{ affiliate.name }}
						</td>
						<td>
							{{ affiliate.email }}
						</td>
						<td>
							{{ affiliate.company }}
						</td>
						<td>

						</td>
						<td>
							{{ affiliate.domains_count }}
						</td>
						<td>
							
						</td>
						<td>
							{{ affiliate.created_at | date 'MMMM Do YYYY' }}
						</td>
					</tr>
				</table>
				<div v-if="!affiliates.length" class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert"></button>
					<h4 class="alert-heading"><strong>Important!</strong></h4>
					<p>No affiliates listed.</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {

		props: {

			affiliates: {
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
		},

		ready() {

		}

	}
</script>