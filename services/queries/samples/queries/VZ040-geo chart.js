//** QUERY
ReportGrid.query
	.count({
		path : pathvalue,
		event : "impression",
		tag : "location",
		location : '/'
	})

//** VIZ
ReportGrid.geo("#chart", {
	axes : ['location', 'count'],
	load : loader,
	options : {
		map : {
			template : "world",
			color : "i:#EEE,#09F,#F63",
			mapping : {
				"ITA" : "italy",
				"PRT" : "portugal",
				"USA" : "usa"
			}
		}
	}
})