(function executeRule(current, previous = null) {
	let serviceClass = current.getDisplayValue('c_service_class');
	let serviceName = current.getValue('name');
	let serviceId = current.getValue('c_id');

	let fullName = serviceClass + ' - ' + serviceName + ' - ' + serviceId;
	current.setValue('c_full_name', fullName);
})(current, previous);
