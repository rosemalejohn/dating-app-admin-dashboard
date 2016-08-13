export default {

	state: {
		spinner: null,
		opts: {
			speed: 2, 
			width: 2, 
			className: 'spinner',
			corners: 5,
			position: 'fixed'
		}
	},

	spin(opts = this.state.opts) {
		this.state.spinner = new Spinner(opts).spin(document.getElementById('body'));
		return true;
	},

	stop() {
		this.state.spinner.stop();
		return false;
	}

}