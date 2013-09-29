//** QUERY
ReportGrid.query
	.data([{ a : 1}, { b : 2 }])
	.stackStore().stackClear()
	.data([{ c : 3}, { d : 4 }])
	.stackRetrieve()