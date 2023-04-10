let dependencyMapper = {
	'cross': ['cross'],
	'commercial_and_marketing': ['customer_development', 'dcommerse', 'marketing', 'unilever_food_solution'],
	'support_functions': ['audit', 'human_resources', 'finance', 'legal', 'tax'],
	'supply_chain': ['cso', 'make', 'mdm', 'planning', 'procurement', 'quality', 'rnd', 'she', 'transport_and_logistic'],
	'it': ['it']
}

let businessFunction = await s_form.getValue('c_business_function');

if (!businessFunction) {
	await s_form.setValue('c_business_sub_function', '');
} else {
	let businessSubFunction = await s_form.getValue('c_business_sub_function');
	if (dependencyMapper[businessFunction].indexOf(businessSubFunction) === -1) {
		await s_form.setValue('c_business_sub_function', '');
	}
}
