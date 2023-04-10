(function executeRule(current, previous = null) {

	let readOnlyFields = ['c_full_name', 'c_decomission_date'];
	for (let i = 0; i < readOnlyFields.length; i++) {
		let field = readOnlyFields[i];
		if (previous.getValue(field) !== current.getValue(field)) {
			ss.addErrorMessage(`You cannot update Read Only field "${current.getLabel(field)}" (${field})`);
			current.setAbortAction(true);
			break;
		}
	}

})(current, previous);
