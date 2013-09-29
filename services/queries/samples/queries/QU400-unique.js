//** LOAD
impressions

//** QUERY
ReportGrid.query
	.data(data())
	.renameFields({ // removes extra fields
		gender : "gender",
		age    : "age"
	})
	.unique()
	.sortValues({
		gender : true,
		age : true
	})