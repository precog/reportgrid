//** DATA
function data() {
	return [
	{ head : "Total Revenue", tail : "Individual income taxes", billions : 1100	},
	{ head : "Total Revenue", tail : "Corporate income taxes", billions : 249 },
	{ head : "Total Revenue", tail : "Social Security/Payroll taxes", billions : 939 },
	{ head : "Total Revenue", tail : "Excise taxes", billions : 78 },
	{ head : "Total Revenue", tail : "Estate and gift taxes", billions : 20 },
	{ head : "Total Revenue", tail : "Customs duties", billions : 24 },
	{ head : "Total Revenue", tail : "Other", billions : 38 },
	{ head : "Total Spending", tail : "Total Revenue", billions : 2400 },
	{ head : "Total Spending", tail : "Deficit", billions : 1200 },
	{ head : "Defense", tail : "Total Spending", billions : 728 },
	{ head : "Other discretionary", tail : "Total Spending", billions : 675 },
	{ head : "Social Security", tail : "Total Spending", billions : 695 },
	{ head : "Medicare", tail : "Total Spending", billions : 453 },
	{ head : "Medicaid", tail : "Total Spending", billions : 290 },
	{ head : "Other Mandatory", tail : "Total Spending", billions : 575 },
	{ head : "Interest on debt", tail : "Total Spending", billions : 178 },
	{ head : "Potentional disaster costs", tail : "Total Spending", billions : 11 }
	];
}

//** VIZ
ReportGrid.sankey("#chart", {
	axes : ["billions"],
	datapoints : data(),
	options : {
		layerwidth : 130
	}
});

//** CLASS
big