(function executeScheduleScript() {

	let service = new SimpleRecord('sys_cmdb_ci_service');
	service.query();

	while (service.next()) {

		let lastReviewedDate = service.getValue('c_last_reviewed_date');
		lastReviewedDate = new SimpleDateTime(lastReviewedDate);
		let now = new SimpleDateTime();
		let difference = new SimpleDateTime().subtract(now, lastReviewedDate);
		let differenceInDays = 180 - difference.getRoundedDayPart();
		service.setValue('c_days_to_review', differenceInDays);
		service.update();

	}

})();