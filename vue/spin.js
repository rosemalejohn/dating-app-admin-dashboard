export default {

	state: {
		spinner: null,
		opts: {
			speed: 3, 
			width: 3, 
			className: 'spinner',
			corners: 5
		}
	},

	spin(opts = this.state.opts) {
		this.state.spinner = new Spinner(opts).spin(document.getElementById('body'));
	},

	stop() {
		this.state.spinner.stop();
	}

}