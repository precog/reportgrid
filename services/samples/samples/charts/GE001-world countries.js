//** LOAD
olympic-medals-2011

//** VIZ
ReportGrid.geo("#chart", {
	axes : ["code", "summerGold"],
	datapoints : data(),
	options : {
		map : {
			template : "world",
			property : "code",
			color : "i:#EEE,#09F,#F63",
			label : {
				datapointover : function(dp, stats) {
					return dp.country
						+ ": "
						+ ReportGrid.format(dp.summerGold)
						+ " gold medals";
				}
			}
		}
	}
});

//** CLASS
wide