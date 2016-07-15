<template>
	<div id="{{ target }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="{{ target + 'Label' }}">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div slot="modal-header">
					<div class="modal-header">
						<button type="button" class="close" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="{{ target + 'Label' }}">{{ title }}</h4>
					</div>
				</div>
				<div class="modal-body">
					<div>
						<slot name="content"></slot>
					</div>	
				</div>
				<div>
					<slot name="modal-footer">
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</slot>
				</div>
				
			</div>
		</div>
	</div>
</template>

<script>
	
export default {
	
	props: {

		title: String,

		target: String

	}

}
</script>