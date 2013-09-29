//** QUERY
ReportGrid.query
	.quirrel("data := load(//organizations); hist('group) := { group: 'group, cnt: count(data where data.category = 'group) }; hist")

//** VIZ
ReportGrid.barChart("#chart", {
	axes : ["group", "cnt"],
	load : loader,
	options : {
		barpadding: 2
	}
});