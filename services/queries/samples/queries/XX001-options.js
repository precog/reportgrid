//** QUERY
ReportGrid.query
	.intersect({
		path : pathvalue,
		event : "impression",
		properties : ["browser", "env", "gender", { property : "age", top : 100 }]
	})