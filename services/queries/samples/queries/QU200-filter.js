//** LOAD
impressions

//** QUERY
ReportGrid.query
	.data(data())
	.filter(function(d) {
		return d.age > 20 && d.age < 25;
	})