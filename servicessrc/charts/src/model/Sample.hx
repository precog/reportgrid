/*
 *  ___ ___ ___  ___  ___ _____ ___ ___ ___ ___           ReportGrid (R)
 * | _ \ __| _ \/ _ \| _ \_   _/ __| _ \_ _|   \          Advanced HTML5 Charting Library
 * |   / _||  _/ (_) |   / | || (_ |   /| || |) |         Copyright (C) 2010 - 2013 SlamData, Inc.
 * |_|_\___|_|  \___/|_|_\ |_| \___|_|_\___|___/          All Rights Reserved.
 *
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the 
 * GNU Affero General Public License as published by the Free Software Foundation, either version 
 * 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See 
 * the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with this 
 * program. If not, see <http://www.gnu.org/licenses/>.
 *
 */
package model;

class Sample
{
	public static var config = 'cache=2 days
[params]
viz[0]=pieChart
viz[1]=barChart
[defaults]
viz=pieChart';
	public static var html   = '<?DOCTYPE html>
<html>
<head>
<title>Viz</title>
<script src="'+App.JS_PATH+'reportgrid-charts.js"></script>
<link type="text/css" href="'+App.CSS_PATH+'rg-charts.css" rel="stylesheet">
<script type="text/javascript">
function render()
{
  ReportGrid.$viz("#chart", {
    data : [{browser:"chrome",count:100},{browser:"firefox",count:80}],
    axes : ["browser","count"]
  });
}
</script>
</head>
<body onload="render()">
<div id="chart"></div>
</body>
</html>';
}