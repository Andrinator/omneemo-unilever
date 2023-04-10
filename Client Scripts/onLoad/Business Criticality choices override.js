let removableOptions = ['Business', 'Operational', 'Underpinning', 'Request'];

removableOptions.forEach(element => {
	s_form.removeOption('service_type', element);
});

let serviceType = await s_form.getValue('service_type');
if (removableOptions.indexOf(serviceType) !== -1) {
	s_form.setValue('service_type', '');
}
