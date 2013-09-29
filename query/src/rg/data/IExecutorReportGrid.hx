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

package rg.data;

interface IExecutorReportGrid
{
	public function children(path : String, options : { ?type : String, ?property : String}, success : Array<String> -> Void, ?error : String -> Void) : Void;
	public function propertyCount(path : String, options : { property : String }, success : Int -> Void, ?error : String -> Void) : Void;
	public function propertySeries(path : String, options : { property : String }, success : TimeSeriesType -> Void, ?error : String -> Void) : Void;
	public function propertyMeans(path : String, options : { property : String, periodicity : String }, success : TimeSeriesType -> Void, ?error : String -> Void) : Void;
	public function propertyStandardDeviations(path : String, options : { property : String, periodicity : String }, success : TimeSeriesType -> Void, ?error : String -> Void) : Void;
	public function propertySums(path : String, options : { property : String, periodicity : String }, success : TimeSeriesType -> Void, ?error : String -> Void) : Void;
	public function propertyValues(path : String, options : { property : String }, success : Array<Dynamic> -> Void, ?error : String -> Void) : Void;
	public function propertyValueCount(path : String, options : { property : String, value : Dynamic }, success : Int -> Void, ?error : String -> Void) : Void;
	public function propertyValueSeries(path : String, options : { property : String, value : Dynamic }, success : TimeSeriesType -> Void, ?error : String -> Void) : Void;
	public function searchCount(path : String, options : { }, success : Int -> Void, ?error : String -> Void) : Void;
	public function searchSeries(path : String, options : { }, success : TimeSeriesType -> Void, ?error : String -> Void) : Void;
	public function intersect(path : String, options : { }, success : Dynamic<Dynamic> -> Void, ?error : String -> Void) : Void;
	public function histogram(path : String, options : { property : String, ?top : Int, ?bottom : Int }, success : Int -> Void, ?error : String -> Void) : Void;
	public function propertiesHistogram(path : String, options :  { property : String, ?top : Int, ?bottom : Int }, success : Int -> Void, ?error : String -> Void) : Void;
	public function events(path : String, options : { event : String }, success : Array<Dynamic> -> Void, ?error : String -> Void) : Void;
}

typedef TimeSeriesType = Array<Array<Dynamic>>;