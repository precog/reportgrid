//** QUERY
ReportGrid.query
	.intersectSeries({
		path : pathvalue,
		event : "impression",
		properties : [{
			property : "browser", top : 2
		}, {
			property : "env", bottom : 5
		}],
		tag : "location",
		location : '/',
		start : "2 days ago",
		end : "now",
		periodicity : "hour"
	})