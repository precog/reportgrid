//** QUERY
ReportGrid.query
	.paths({ parent : "/test" })
	.renameFields({ "path" : "parent" })
	.paths()
	.events()
	.properties()
	.sortValues({
		path : true,
		event : true,
		property : true
	})
