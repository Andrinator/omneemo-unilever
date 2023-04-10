(async () => {
	validateSForm();
})();

function validateSForm() {
	if (window['s_form'] && s_form.isValid() === undefined) {
		s_go.reloadWindow();
	}
}