//** LOAD
impressions

//** QUERY
ReportGrid.query
	.data(data())
	.filterValue("age", function(age) {
		return age > 20 && age < 25;
	})
	.filterValue("browser", "chrome")