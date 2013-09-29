//** LOAD
fic-sales

//** VIZ
ReportGrid.pivotTable("#chart", {
	axes : ["model", "quarter", "market", "value"],
	datapoints : data(),
	options : {
		columnaxes : 2,
		displayheatmap : false,
		cellclass : function(dp, stats) {
			return "x-cell";
		},
		valueclass : function(value, header) {
			return "x-value " + value;
		},
		headerclass : function(header) {
			return "x-header " + header[0];
		},
		totalclass : function(total, headers) {
			return "x-total";
		}
	}
});

//** CLASS
big

//** STYLE
.x-cell
{
	font-weight: bold !important;
	color: red !important;
}

.x-value
{
	font-weight: bold !important;
	color: green !important;
}

.x-header
{
	font-weight: bold !important;
	color: blue !important;
}

.x-total
{
	font-weight: bold !important;
	color: pink !important;
}

.Small
{
	font-size: 9px !important;
}

.Medium
{
	font-size: 16px !important;
}

.Big
{
	font-size: 32px !important;
}