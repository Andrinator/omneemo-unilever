class SimpleWidget {

	constructor() {

	}

	addTemplate(id, template, script, type) {

	}

	getData() {

	}

	getElements() {

	}

	getFieldValue(key) {

	}

	getForm() {

	}

	getId() {

	}

	getOptionValue(key) {

	}

	removeTemplate(id) {

	}

	setFieldValue(key, value) {

	}

	serverUpdate() {

	}

	setOptionValue(key, value) {

	}

	showData() {

	}

}

class SimpleWidgets {

	constructor() {
	}

	getFieldValue(widgetInstanceID, key) {

	}

	getForm(formName) {

		return new SimpleForm();

	}

	getWidgets() {

	}

	setFieldValue(widgetInstanceID, key, value) {

	}

}

let s_widget = new SimpleWidget();
let s_widgets = new SimpleWidgets();