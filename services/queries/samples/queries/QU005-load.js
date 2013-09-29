//** LOAD
impressions

//** QUERY
ReportGrid.query
	.load(function(h) {
		setTimeout(function() {
			h(data());
		}, 1000);
	})