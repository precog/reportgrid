//** QUERY
ReportGrid.query
	.intersect({
		path : "/test/clipmaster/t4/",
		event : "impression",
		properties : ['clip', 'parent']
	})
	.renameFields({
		clip   : "head",
		parent : "tail",
		count  : "impressions"
	})

//** VIZ
ReportGrid.sankey("#chart", {
	axes : ["impressions"],
	load : loader
});