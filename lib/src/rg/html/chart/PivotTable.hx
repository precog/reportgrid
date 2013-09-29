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
/**
 * ...
 * @author Franco Ponticelli
 */

package rg.html.chart;
import rg.axis.Stats;
import thx.color.Hsl;
import rg.axis.Stats;
import dhx.Selection;
import rg.util.RGStrings;
import rg.util.Periodicity;
import thx.color.Rgb;
import rg.axis.IAxis;
import rg.axis.AxisTime;
import rg.data.Variable;
import rg.data.VariableDependent;
import rg.data.VariableIndependent;
import rg.util.DataPoints;
import thx.culture.FormatNumber;
import dhx.Access;
import rg.util.Properties;
import hxevents.Notifier;
using Strings;
using Arrays;

// TODO add sorting (probably in VisualizationPivotTable)
class PivotTable
{
	static var defaultColorStart = new Hsl(210, 1, 1);
	static var defaultColorEnd   = new Hsl(210, 1, 0.5);

	public var displayColumnTotal : Bool;
	public var displayRowTotal : Bool;
	public var displayHeatMap : Bool;
	public var colorStart : Hsl;
	public var colorEnd : Hsl;
	public var ready(default, null) : Notifier;

	var columnVariables : Array<VariableIndependent<Dynamic>>;
	var rowVariables : Array<VariableIndependent<Dynamic>>;
	var cellVariable : VariableDependent<Dynamic>;

	public var incolumns : Int;

	public var click : Dynamic -> Void;
	public var cellclass : Dynamic -> Stats<Dynamic> -> String;
	public var valueclass : Dynamic -> String -> String;
	public var headerclass : String -> String;
	public var totalclass : Dynamic -> Array<Dynamic> -> String;

	var container : Selection;
	var stats : StatsNumeric;

	public function new(container : Selection)
	{
		this.ready = new Notifier();
		this.container = container;

		displayColumnTotal = true;
		displayRowTotal = true;
		displayHeatMap = true;
		colorStart = defaultColorStart;
		colorEnd = defaultColorEnd;
		incolumns = 1;
	}

	public dynamic function labelDataPoint(dp : Dynamic, stats : StatsNumeric)
	{
		var v = DataPoints.value(dp, cellVariable.type);
		if(Math.isNaN(v))
			return "0";
		return FormatNumber.int(v);
	}

	public dynamic function labelDataPointOver(dp : Dynamic, stats : StatsNumeric)
	{
		var v = DataPoints.value(dp, cellVariable.type);
		if(Math.isNaN(v))
			return "0";
		return FormatNumber.percent(100 * v / stats.tot, 1);
	}

	public dynamic function labelAxis(v : String)
	{
		return Properties.humanize(v);
	}

	public dynamic function labelAxisValue(v : Dynamic, axis : String)
	{
		if (Properties.isTime(axis))
		{
			var p = Properties.periodicity(axis);
			return Periodicity.format(p, v);
		} else
			return RGStrings.humanize(v);
	}


	public dynamic function labelTotal(v : Float, stats : StatsNumeric)
	{
		return FormatNumber.int(v);
	}

	public dynamic function labelTotalOver(v : Float, stats : StatsNumeric)
	{
		return FormatNumber.percent(100 * v / stats.tot, 1);
	}

	public function data(dps : Array<Dynamic>)
	{
		var d = transformData(dps),
			table = container.append("table").classed().add("pivot-table"),
			thead = table.append("thead"),
			leftspan = d.rows.length > 0 ? d.rows[0].values.length : 0,
			color = Rgb.interpolatef(colorStart, colorEnd);
		stats = d.stats;

		// HEADER
		if (d.columns.length > 0)
		{
			for (i in 0...d.column_headers.length)
			{
				var tr = thead.append("tr");
				prependSpacer(leftspan, tr);

				var header = tr
					.append("th")
					.text().string(labelAxis(d.column_headers[i]));
				var clsbuf = ["col-header"];
				if(null != headerclass)
				{
					var v = headerclass(d.column_headers[i]);
					if(null != v)
						clsbuf.push(v);
				}
				header.attr("class").string(clsbuf.join(" "));
				if(d.columns.length > 1)
					header.attr("colspan").float(d.columns.length);

				var counter = 1, last = d.columns[0].values[i];

				tr = thead.append("tr");

				if (i == d.column_headers.length - 1)
				{
					for (h in d.row_headers)
					{
						var th = tr
							.append("th")
							.text().string(labelAxis(h));

						var clsbuf = ["row-header"];
						if(null != headerclass)
						{
							var v = headerclass(h);
							if(null != v)
								clsbuf.push(v);
						}
						th.attr("class").string(clsbuf.join(" "));
					}
				} else
					prependSpacer(leftspan, tr);

				for (j in 1...d.columns.length)
				{
					var value = d.columns[j].values[i];
					if (last == value)
					{
						counter++;
					} else {
						buildValue(last, d.column_headers[i], counter, tr);
						counter = 1;
						last = value;
					}
				}
				if (null != last)
				{
					buildValue(last, d.column_headers[i], counter, tr);
				}
			}
		}

		if(d.column_headers.length == 0)
		{
			var tr = thead.append("tr");
			for (h in d.row_headers)
			{
				tr
					.append("th")
					.attr("class").string("row header")
					.text().string(labelAxis(h));
			}
		}

		// BODY
		var tbody = table.append("tbody"),
			last = [];
		for (row in d.rows)
		{
			var tr = tbody.append("tr"),
				len = row.values.length;
			for (i in 0...len)
			{
				var v = row.values[i],
					rep = v == last[i];
				if (!rep)
				{
					last[i] = v;
					for (j in i + 1...len)
						last[j] = null;
				}
				var th = tr.append("th")
//					.attr("class").string(rep ? "row value empty" : "row value")
					.text().string(rep ? "" : labelAxisValue(v, d.row_headers[i]));

				var clsbuf = ["row value"];
				if(rep)
				{
					clsbuf.push("empty");
				}
				if(null != valueclass)
				{
					var cls = valueclass(v, d.row_headers[i]);
					if(null != cls)
						clsbuf.push(cls);
				}
				th.attr("class").string(clsbuf.join(" "));
			}

			var v;
			for (cell in row.cells)
			{
				var td = tr.append("td")
					.text().string(formatDataPoint(cell))
					.attr("title").string(formatDataPointOver(cell));
				if (null != click)
					td.onNode("click", onClick.bind(cell));
				if (displayHeatMap && !Math.isNaN(v = DataPoints.value(cell, cellVariable.type) / d.stats.max))
				{
					var c = color(v);
					td
						.style("color").color(Rgb.contrastBW(c))
						.style("background-color").color(c)
					;
				}
				var clsbuf = [];
				if(null != cellclass)
				{
					var cls = cellclass(cell, row.stats);
					if(null != cls)
						clsbuf.push(cls);
				}
				td.attr("class").string(clsbuf.join(" "));
			}

			if (displayRowTotal && d.columns.length > 1)
			{
				var th = tr.append("th")
//					.attr("class").string("row total")
					.text().string(formatTotal(row.stats.tot));
				var title = formatTotalOver(row.stats.tot);
				if(null != title)
					th.attr("title").string(title);
				var clsbuf = ["row total"];
				if(null != totalclass)
				{
					var cls = totalclass(row.stats.tot, row.values);
					if(null != cls)
						clsbuf.push(cls);
				}
				th.attr("class").string(clsbuf.join(" "));
			}
		}

		// FOOT
		var tfoot = table.append("tfoot");

		if (displayColumnTotal && d.rows.length > 1)
		{
			var tr = tfoot.append("tr");
			prependSpacer(leftspan, tr);
			for (col in d.columns)
			{
				var title = formatTotalOver(col.stats.tot);
				var th = tr.append("th")
//					.attr("class").string("column total")
					.text().string(formatTotal(col.stats.tot));
				if(null != title)
					th.attr("title").string(title);

				var clsbuf = ["column total"];
				if(null != totalclass)
				{
					var cls = totalclass(col.stats.tot, col.values);
					if(null != cls)
						clsbuf.push(cls);
				}
				th.attr("class").string(clsbuf.join(" "));
			}

			if(displayRowTotal && d.columns.length > 1)
			{
				var th = tr.append("th")
//					.attr("class").string("table total")
					.text().string(formatTotal(d.stats.tot))
					.attr("title").string(formatTotalOver(d.stats.tot));

				var clsbuf = ["table total"];
				if(null != totalclass)
				{
					var cls = totalclass(d.stats.tot, []);
					if(null != cls)
						clsbuf.push(cls);
				}
				th.attr("class").string(clsbuf.join(" "));
			}
		}
		ready.dispatch();
	}

	function onClick(dp, _, _)
	{
		click(dp);
	}

	function formatTotal(v : Float, ?_) return labelTotal(v, stats);
	function formatTotalOver(v : Float, ?_) return labelTotalOver(v, stats);
	function formatDataPoint(dp : Dynamic, ?_) return labelDataPoint(dp, stats);
	function formatDataPointOver(dp : Dynamic, ?_) return labelDataPointOver(dp, stats);

	function buildValue(value : Dynamic, header : String, counter : Int, tr : Selection)
	{
		var th = tr
			.append("th")
//			.attr("class").string("column value")
			.text().string(labelAxisValue(value, header));
		if (counter > 1)
			th.attr("colspan").float(counter);

		var clsbuf = ["column value"];
		if(null != valueclass)
		{
			var cls = valueclass(value, header);
			if(null != cls)
				clsbuf.push(cls);
		}
		th.attr("class").string(clsbuf.join(" "));
	}

	function prependSpacer(counter : Int, tr : Selection)
	{
		if (counter == 0)
			return;
		var th = tr.append("th")
			.attr("class").string("spacer");
		if (counter > 1)
			th.attr("colspan").float(counter);
	}

	public function init()
	{

	}

	public function setVariables(variableIndependents : Array<VariableIndependent<Dynamic>>, variableDependents : Array<VariableDependent<Dynamic>>)
	{
		cellVariable = variableDependents[0];
		columnVariables = [];
		for (i in 0...incolumns)
			columnVariables.push(variableIndependents[i]);

		rowVariables = [];
		for (i in incolumns...variableIndependents.length)
			rowVariables.push(variableIndependents[i]);
	}

	public function destroy()
	{
		container.html().string("");
	}

	function transformData(dps : Array<Dynamic>): {
		column_headers : Array<String>,
		row_headers : Array<String>,
		columns : Array<{ values : Array<Dynamic>, stats : StatsNumeric, type : String }>,
		rows : Array<{ values : Array<Dynamic>, cells : Array<Dynamic>, stats : StatsNumeric} >,
		stats : StatsNumeric
	}
	{
		var column_headers = [],
			row_headers = [],
			columns = [],
			rows = [],
			tcalc = new StatsNumeric(null);

		var variable;
		// columns : build first level
		for (i in 0...Ints.min(1, columnVariables.length))
		{
			variable = columnVariables[i];
			column_headers.push(variable.type);
			for (value in range(variable))
			{
				columns.push({
					values : [value],
					stats : null,
					type : variable.type
				});
			}
		}
		// columns : append others
		for (i in 1...columnVariables.length)
		{
			variable = columnVariables[i];
			column_headers.push(variable.type);
			var tmp = columns.copy();
			columns = [];
			for (src in tmp)
			{
				for (value in range(variable))
				{
					var column = Objects.clone(src);
					column.values.push(value);
					columns.push(column);
				}
			}
		}

		var name,
			headers = column_headers;
		for (i in 0...columns.length)
		{
			var column = columns[i],
				ccalc = new StatsNumeric(null); // { min : Math.POSITIVE_INFINITY, max : Math.NEGATIVE_INFINITY, tot : 0.0 };
			column.stats = ccalc;
			for (dp in dps.filter(function(dp) {
				for (j in 0...headers.length)
				{
					name = headers[j];
					if(
						(Properties.isTime(name) &&
						 Dates.snap(Reflect.field(dp, name), Properties.periodicity(name)) == column.values[j])
						|| Reflect.field(dp, name) == column.values[j]
					)
						return true;
				}
				return false;
			}))
			{
				var v = Reflect.field(dp, cellVariable.type);
				if (null == v)
					continue;
				ccalc.add(v);
				tcalc.add(v);
			}
		}

		// rows : build first level
		for (i in 0...Ints.min(1, rowVariables.length))
		{
			variable = rowVariables[i];
			row_headers.push(variable.type);
			for (value in range(variable))
			{
				rows.push({
					values : [value],
					stats : null,
					cells : null
				});
			}
		}
		// rows : append others
		for (i in 1...rowVariables.length)
		{
			variable = rowVariables[i];
			row_headers.push(variable.type);
			var tmp = rows.copy();
			rows = [];
			for (src in tmp)
			{
				for (value in range(variable))
				{
					var row = Objects.clone(src);
					row.values.push(value);
					rows.push(row);
				}
			}
		}
		var name,
			headers = row_headers;
		for (i in 0...rows.length)
		{
			var row = rows[i];
			row.stats = new StatsNumeric(null);
			row.cells = [];

			var rdps;
			rdps = dps.filter(function(d) {
				for (j in 0...headers.length)
				{
					name = headers[j];
					if(
						(Properties.isTime(name) &&
						 Dates.snap(Reflect.field(d, name), Properties.periodicity(name)) != row.values[j])
						|| Reflect.field(d, name) != row.values[j]
					)
						return false;
				}
				return true;
			});

			for (k in 0...columns.length)
			{
				var column = columns[k];
				if(Properties.isTime(column.type))
				{
					var periodicity = Properties.periodicity(column.type);
					var dp = rdps.firstf(function(dp) {
						for (i in 0...column.values.length)
						{
							if (Dates.snap(Reflect.field(dp, column_headers[i]), periodicity) != column.values[i])
								return false;
						}
						return true;
					});
					var v = Reflect.field(dp, cellVariable.type);
					if (null == v)
					{
						row.cells.push({});
						continue;
					}
					row.cells.push(dp);
					row.stats.add(v);
				} else {
					var dp = rdps.firstf(function(dp) {
						for (i in 0...column.values.length)
						{
							if (Reflect.field(dp, column_headers[i]) != column.values[i])
								return false;
						}
						return true;
					});
					var v = Reflect.field(dp, cellVariable.type);
					if (null == v)
					{
						row.cells.push({});
						continue;
					}
					row.cells.push(dp);
					row.stats.add(v);
				}
			}
		}

		return {
			column_headers : column_headers,
			row_headers : row_headers,
			columns : columns,
			rows : rows,
			stats : tcalc
		};
	}

	function range(variable : VariableIndependent<Dynamic>)
	{
		return variable.axis.range(variable.min(), variable.max());
	}
}