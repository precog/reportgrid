//** QUERY
ReportGrid.query
    .data([{event : "i", count : 0, "time:day" : 1332201600000}, {event : "i", count : 0, "time:day" : 1332288000000}, {event : "i", count : 0, "time:day" : 1332374400000}, {event : "i", count : 0, "time:day" : 1332460800000}, {event : "i", count : 0, "time:day" : 1332547200000}, {event : "i", count : 0, "time:day" : 1332633600000}, {event : "i", count : 0, "time:day" : 1332720000000}, {event : "c", count : 0, "time:day" : 1332201600000}, {event : "c", count : 0, "time:day" : 1332288000000}, {event : "c", count : 0, "time:day" : 1332374400000}, {event : "c", count : 0, "time:day" : 1332460800000}, {event : "c", count : 0, "time:day" : 1332547200000}, {event : "c", count : 0, "time:day" : 1332633600000}, {event : "c", count : 0, "time:day" : 1332720000000}])
    .split("time:day").transform(function(dataset) {
            return [{
                "event" : "impression",
                "value" : dataset[0].count,
                "time:day" : dataset[0]["time:day"]
              }, {
                "event" : "click",
                "value" : dataset[1].count,
                "time:day" : dataset[0]["time:day"]
              }, {
                "event" : "ctr",
                "value" : dataset[1].count / dataset[0].count,
                "time:day" : dataset[0]["time:day"]
              }];
    })
    .console()

//** VIZ
var params = { path : "/query/test2", start : "24 days ago", periodicity : "day" };
ReportGrid.pivotTable("#chart", {
    axes : ["time:day", "event", "value"],
    load : loader
})