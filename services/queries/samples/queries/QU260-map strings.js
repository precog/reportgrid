//** LOAD
names

//** QUERY
ReportGrid.query
	.data(data())
	.map(function(d, i) {
		return { name : d, index : i };
	})