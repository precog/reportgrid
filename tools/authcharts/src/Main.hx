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
import thx.sys.Web;
import thx.sys.Lib;
import thx.sys.Sys;
import chx.crypt.RSA;

class Main
{
	static var params = Web.getParams();
	static function main()
	{
		var host = params.get("host");
		if(null == host)
			out(null);
		var result = {
			host : host,
			key : encrypt(host)
		};

		out(result);
	}

	static function encrypt(s : String)
	{
		var rsa = new RSA(Key.modulus, Key.publicExponent, Key.privateExponent);
		return chx.formats.Base64.encode(rsa.sign(Bytes.ofString(s)));
	}

	static function out(o : Dynamic)
	{
		var cback = params.get("callback"),
			json = thx.json.Json.encode(o);
		if(null == cback)
			Lib.print(json);
		else
			Lib.print(cback + "(" + json + ");");
		Sys.exit(null == o ? 1 : 0);
	}
}