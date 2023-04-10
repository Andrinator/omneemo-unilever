let removableOptions = ['0', '1', '2'];

removableOptions.forEach(element => {
	s_form.removeOption('ci_status', element);
});

let state = await s_form.getValue('ci_status');
if (removableOptions.indexOf(state) !== -1) {
	s_form.setValue('ci_status', 'assessment_not_started');
}
