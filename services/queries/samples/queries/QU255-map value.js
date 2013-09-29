//** QUERY
ReportGrid.query
	.data([{a : 0}, {a : 1}, {a : 2}, {a : 3}])
	.mapValue("a", function(v) {
		return v * v;
	})