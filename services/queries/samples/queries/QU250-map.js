//** LOAD
persons

//** QUERY
ReportGrid.query
	.data(data())
	.map(function(d) {
		var ob = {};
		for(var key in d)
			ob[key.toUpperCase()] = d[key];
		return ob;
	})