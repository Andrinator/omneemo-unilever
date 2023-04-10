let dependencyMapper = {
	'cross': ['cross'],
	'commercial_and_marketing': ['customer_development', 'dcommerse', 'marketing', 'unilever_food_solution'],
	'support_functions': ['audit', 'human_resources', 'finance', 'legal', 'tax'],
	'supply_chain': ['cso', 'make', 'mdm', 'planning', 'procurement', 'quality', 'rnd', 'she', 'transport_and_logistic'],
	'it': ['it']
}

let businessFunction = s_form.getValue('c_business_function');

if (businessFunction) {
	s_form.setVisible('c_business_sub_function', true);
	setDependencies(businessFunction).then(() => {
		return null;
	});

} else {
	s_form.setVisible('c_business_sub_function', false);
	s_form.setValue('c_business_sub_function', '');
}

async function setDependencies(parentValue) {

	for (let [key, valueArray] of Object.entries(dependencyMapper)) {
		if (key === parentValue) {
			for (let value of valueArray) {
				await s_form.addOption('c_business_sub_function', value);
			}
		} else {
			for (let value of valueArray) {
				s_form.removeOption('c_business_sub_function', value);
			}
		}
	}

}