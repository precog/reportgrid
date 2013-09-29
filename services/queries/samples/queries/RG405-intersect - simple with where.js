//** QUERY
ReportGrid.query
	.intersect({
		path : pathvalue,
		event : "impression",
		properties : [{ property : "browser" }],
		where : { gender : "male", age : 18 }
	})