//** LOAD
persons

//** QUERY
ReportGrid.query
	.data(data())
	.sortValues({
		officecenterdist : false,
		name : true
	})