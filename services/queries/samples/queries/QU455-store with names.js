//** QUERY
ReportGrid.query
	.data([{ a : 1}, { b : 2 }])
	.stackStore("first").stackClear()
	.data([{ c : 3}, { d : 4 }])
	.stackStore("second").stackClear()
	.data([{ e : 5}, { f : 6 }])
	.stackStore("third").stackClear()
	.stackRetrieve("first")
	.stackRetrieve("second")
	.stackRetrieve("third")