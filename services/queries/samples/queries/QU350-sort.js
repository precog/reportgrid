//** LOAD
persons

//** QUERY
ReportGrid.query
	.data(data())
	.sort(function(a, b) {
		return a.officecenterdist - b.officecenterdist;
	})