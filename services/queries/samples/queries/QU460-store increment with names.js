//** QUERY
ReportGrid.query
	.data([{ a : 1}, { b : 2 }])
	.stackStore("first")
	.data([{ c : 3}, { d : 4 }])
	.stackCross()
	.stackStore("second")
	.data([{ e : 5}, { f : 6 }])
	.stackCross()
	.stackStore("third").stackClear()
	.stackRetrieve("first")
	.stackRetrieve("second")
	.stackRetrieve("third")