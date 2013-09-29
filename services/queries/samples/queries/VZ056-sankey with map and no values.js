//** QUERY
ReportGrid.query
	.data([])

//** VIZ
ReportGrid.sankey("#chart", {
	axes : ["impressions"],
	load : loader,
	options : {
		layoutmap : layoutmap()
	}
});


function layoutmap() {
 	return {
		layers : [["clip_01"], ["clip_03", "clip_02", "clip_04"], ["#1", "#2", "clip_05", "#3"], ["clip_06", "#4", "#5"], ["clip_07"]],
		dummies : [
			["clip_03", "#1", "clip_06"],
			["clip_02", "#2", "clip_06"],
			["clip_05", "#4", "clip_07"],
			["clip_04", "#3", "#5", "clip_07"]
		]
	};
}