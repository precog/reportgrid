//** LOAD
persons

//** QUERY
ReportGrid.query
	.data(data())
	.sortValues({
		officecenterdist : true,
		name : false
	})