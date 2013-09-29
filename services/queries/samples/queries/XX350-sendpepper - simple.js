//** TOKEN
F9AE2B0E-532A-4FEC-9846-14DC6768F458

//** QUERY
ReportGrid.query
    .count({ path : "/customers/333/logs/", event : ".Email Sent", where : { item_id : "354" } })
    .console()
//    .execute(function(_) {})
/*
ReportGrid.query
    .count({
        path : "/cutomers/333/logs/",
        event : "Email Sent"
    })
    .console()
    .execute(function(_) {});
*/