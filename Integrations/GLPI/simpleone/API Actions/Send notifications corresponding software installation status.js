(function (request, response) {

	const reqBody = request.getBody();
	ss.info('API action worked');
	ss.info(JSON.stringify(reqBody));
	response.setBody({
		"request_body_type": typeof reqBody,
		"request_body": 'Test'
	});
	let apiAction = new SimpleRecord('sys_api_action');
	apiAction.get('168122401490216326');
	ss.eventQueue('glpi_software_successfully_installed', apiAction);

})(SimpleApiRequest, SimpleApiResponse)