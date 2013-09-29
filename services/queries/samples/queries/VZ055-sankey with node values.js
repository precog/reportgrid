//** QUERY
ReportGrid.query
	.intersect({
		path : "/test/clipmaster/t4/",
		event : "impression",
		properties : ['clip']
	})
	.renameFields({
		clip : "id",
		count : "impressions"
	})
	.stackStore()
	.stackClear()
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
	.stackRetrieve()

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