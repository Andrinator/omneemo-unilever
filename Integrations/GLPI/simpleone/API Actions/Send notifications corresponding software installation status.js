(function (request, response) {

	const reqBody = request.getBody();
	ss.info('API action worked');
	ss.info(JSON.stringify(reqBody));

})(SimpleApiRequest, SimpleApiResponse)