//** LOAD
impressions

//** QUERY
ReportGrid.query
	.data(data())
	.unique(function(a, b) {
		return a.gender == b.gender && a.age == b.age
	})
	.sortValues({ gender : true, age : true })