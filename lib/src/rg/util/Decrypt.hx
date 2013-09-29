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
package rg.util;
import chx.crypt.RSA;
import chx.crypt.RSAEncrypt;

class Decrypt
{
	public static function decrypt(s : String)
	{
		var r = new RSAEncrypt(modulus, publicExponent),
			d = chx.formats.Base64.decode(s);
		try
		{
			return r.verify(d).toString();
		} catch(e : Dynamic)
		{
			return null;
		}
	}

	static var modulus: String = "00:ca:a7:37:07:b0:26:63:cb:f1:37:9d:e9:cc:c1:bd:f1:57:f5:90:72:4d:74:e2:5f:33:df:6c:c4:e4:7f:95:3c:87:89:ed:3c:60:cc:b0:15:f9:ad:57:77:52:4b:25:9b:c8:f9:d0:8a:b8:0a:ab:17:3d:7c:cf:1d:19:a3:8c:43:9b:ee:5b:2e:9e:45:18:b3:97:2a:91:c2:90:c2:1e:49:a3:5e:b1:48:09:1c:ee:06:b9:6e:ec:22:e6:2d:06:b8:b4:22:5f:4d:5e:81:6a:91:13:30:5d:6c:b5:7c:cc:fa:47:dc:8e:b4:f3:fd:0a:6e:d2:f8:09:3c:b1:c2:90:19";
	static var publicExponent: String = "3";
}