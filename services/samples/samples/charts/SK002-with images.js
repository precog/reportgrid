//** LOAD
fic-clips

//** VIZ
ReportGrid.sankey("#chart", {
	axes : ["count"],
	datapoints : data(),
	options : {
		imagewidth : 60,
		imageheight : 40,
		imagespacing : 1,
		imagepath : function(dp)
		{
			return "http://www.reportgrid.com/charts/samples/images/"
				+ dp.id.replace(" ", "_").toLowerCase()
				+ ".png";
		},
		nodespacing : 63,
		layoutmethod : "weightbalance",
		stackbackedges : true,
		thinbackedges : true
	}
});

//** CLASS
big