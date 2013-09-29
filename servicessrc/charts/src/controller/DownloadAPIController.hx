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
package controller;

import model.CacheGateway;
import model.ConfigRendering;
import model.ConfigTemplate;
import model.RenderableGateway;
import model.WKHtmlToImage;
import model.WKHtmlToPdf;
import model.Renderable;
import thx.collection.HashList;
import ufront.web.mvc.Controller;
import ufront.web.mvc.ContentResult;
import template.Error;

class DownloadAPIController extends Controller
{
	var cache : CacheGateway;
	var renderables : RenderableGateway;
	var topdf : WKHtmlToPdf;
	var toimage : WKHtmlToImage;
	public function new(cache : CacheGateway, renderables : RenderableGateway, topdf : WKHtmlToPdf, toimage : WKHtmlToImage)
	{
		super();
		this.cache = cache;
		this.renderables = renderables;
		this.topdf = topdf;
		this.toimage = toimage;
	}

	public function download(uid : String, ext : String, forceDownload = false)
	{
		var renderable = renderables.load(uid);
//		trace(renderable);
		if(null == renderable)
			return error(Std.format("uid '$uid' doesn't exist"), ext);


		return renderRenderable(renderable, ext, forceDownload);
		/*
		if(!renderable.canRenderTo(ext))
			return error(Std.format("this visualization cannot be rendered to '$ext'"), ext);

		var params = getParams(renderable.config.template),
			cached = cache.load(uid, ext, params);
		if(null == cached)
		{
			var html;
			try {
				html = processHtml(renderable.html, params, renderable.config.template);
			} catch(e : Dynamic) {
				return error(""+e, ext);
			}
			var content = renderHtml(html, renderable.config, ext);
			cached = cache.insert(uid, ext, params, content, Date.now().getTime() + renderable.config.cacheExpirationTime);
		}

		setHeaders(ext, cached.content.bin.length);

		// log usage
		renderables.use(uid);
		return cached.content.bin;
		*/
	}

	public function renderRenderable(renderable : Renderable, ext : String, forceDownload : Bool)
	{
		if(!renderable.canRenderTo(ext))
			return error(Std.format("this visualization cannot be rendered to '$ext'"), ext);

		var params = getParams(renderable.config.template),
			cached = cache.load(renderable.uid, ext, params);
		if(null == cached)
		{
			var html;
			try {
				html = processHtml(renderable.html, params, renderable.config.template);
			} catch(e : Dynamic) {
				return error(""+e, ext);
			}
			var content = renderHtml(html, renderable.config, ext);
			cached = cache.insert(renderable.uid, ext, params, content, Date.now().getTime() + renderable.config.cacheExpirationTime);
		}

		setHeaders(ext, cached.content.bin.length, forceDownload);

		// log usage
		renderables.use(renderable.uid);
		return cached.content.bin;
	}

	function getParams(config : ConfigTemplate)
	{
		var params = new HashList<String>(),
			requestParams = controllerContext.request.params,
			value;
		for(param in config.replaceables())
		{
			value = requestParams.get(param);
			if(null == value)
				value = config.getDefault(param);
			if(null == value)
				throw new thx.error.Error("the parameter '{0}' is mandatory", [value]);
			params.set(param, value);
		}
		return params;
	}

	function processHtml(html : String, params : HashList<String>, config : ConfigTemplate)
	{
		for(param in config.replaceables())
		{
			var value = params.get(param);
			if(!config.isValid(param, value))
				throw new thx.error.Error("invalid value '{0}' for the parameter '{1}'", [value, param]);
			html = StringTools.replace(html, '$'+param, ""+value);
		}
		return html;
	}

	function error(msg : String, ext : String)
	{
		trace(Std.format("ERROR: $msg (.$ext)"));
		var ext = ext.toLowerCase(),
			content = new Error().execute({
        		baseurl : App.baseUrl(),
				url : new ufront.web.mvc.view.UrlHelper.UrlHelperInst(controllerContext.requestContext),
				data : { error : msg }
			});
		return renderHtml(content, null, ext);
	}

	function renderHtml(html : String, config : ConfigRendering, ext : String)
	{
		var result;
		switch (ext) {
			case 'pdf', 'ps':
				topdf.format = ext;
				if(null != config)
				{
					topdf.wkConfig = config.wk;
					topdf.pdfConfig = config.pdf;
				}
				result = topdf.render(html);
			case 'png', 'jpg', 'bmp', 'tif', 'svg':
				toimage.format = ext;
				if(null != config)
				{
					toimage.wkConfig = config.wk;
					toimage.imageConfig = config.image;
				}
				result = toimage.render(html);
			default: // html
				result = html;
		}
		setHeaders(ext, result.length, false);
		return result;
	}

	function setHeaders(ext : String, len : Int, forceDownload : Bool)
	{
		var response = controllerContext.response;
		switch (ext) {
			case 'pdf':
				response.contentType = 'application/pdf';
			case 'ps':
				response.contentType = 'application/postscript';
			case 'png':
				response.contentType = 'image/png';
			case 'svg':
				response.contentType = 'image/svg+xml';
			case 'jpeg', 'jpg':
				response.contentType = 'image/jpeg';
			case 'bmp':
				response.contentType = 'image/bmp';
			case 'tif', 'tiff':
				response.contentType = 'image/tiff';
			default: // html
		}

		if(forceDownload)
		{
			response.setHeader("Content-Description", "File Transfer");
			response.setHeader("Content-Disposition", Std.format("attachment; filename=visualization.$ext"));
			response.setHeader("Content-Transfer-Encoding", "binary");
		}

		response.setHeader("Content-Length", "" + len);
	}
}