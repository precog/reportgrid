//** LOAD
impressions

//** QUERY
ReportGrid.query
	.data(data())
	.filterValues({
		age : function(age) { return age > 20 && age < 25; },
		browser : "chrome"
	})