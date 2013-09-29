//** TOKEN
3D077335-1CF8-4614-A928-DB3FFC63291C

//** VIZ
function writeCPM(dataset){
    document.getElementById("chart").innerHTML = ReportGrid.format(dataset);
};

var params = { path : "/dev/", event:"c", start : "107 days ago", end : "now", periodicity : "day" };
ReportGrid.query
    .data(params).summary({property:"price", type:"sum"}) .stackStore("sum") .stackClear()
    .data(params).count({}).stackRetrieve("sum") .stackMerge()
    .console()
    .transform(function(dataset) {
        if(!dataset[0] || !dataset[1])
            return 0;
        else
            return dataset[1]["sum"]/dataset[1]["count"];
    })
    .console()
    .execute(writeCPM);