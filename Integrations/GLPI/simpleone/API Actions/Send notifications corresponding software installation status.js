(function (request, response) {

	const reqBody = request.getBody();
	// ss.info('API action worked');
	// ss.info(JSON.stringify(reqBody));
	response.setBody({
		"request_body_type": typeof reqBody,
		"request_body": 'Test'
	})

})(SimpleApiRequest, SimpleApiResponse)