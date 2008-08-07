function SelectionRect(x, y, width, height) {
	this.x = typeof(x) == "undefined" ? null : x;
	this.y = typeof(y) == "undefined" ? null : y;
	this.width = typeof(width) == "undefined" ? null : width;
	this.height = typeof(height) == "undefined" ? null : height;
	this.divElm = null;
	this.mouseDown = false;
	this.minX = this.minY = null;
	this.maxX = this.maxX = null;
	this.action = "";
	this.mouseDownX = this.mouseDownY = 0;
	this.fixedProps = false;
	this.opacity = false;
	this.resize = true;
	this.visible = true;

	this.isMSIE = (navigator.appName == "Microsoft Internet Explorer");
	this.isGecko = navigator.userAgent.indexOf('Gecko') != -1;
	this.isMSIE5_0 = this.isMSIE && (navigator.userAgent.indexOf('MSIE 5.0') != -1);
	this.isOpera = navigator.userAgent.indexOf('Opera') != -1;

	// this.opacity = !this.isOpera && !this.isMSIE;
};

SelectionRect.prototype.reinit = function(width, height) {
	var elm = this.wrapperElement;

	this.innerWrapperElement.style.width = width + "px";
	this.innerWrapperElement.style.height = height + "px";

	this.setBounderies(0, 0, width, height);

	this.update();
};

SelectionRect.prototype.init = function(parent_node) {
	if (typeof(parent_node) == "undefined")
		parent_node = document.body;

	this.wrapperElement = parent_node;
	this.wrapperPos = this.getAbsPosition(this.wrapperElement);

	this.eventMaxX = parent_node.clientWidth;
	this.eventMaxY = parent_node.clientHeight;

	// Setup bounderies
	if (this.minX == null)
		this.setBounderies(0, 0, parent_node.scrollWidth, parent_node.scrollHeight);

	if (typeof(document._selectionRectCounter) == "undefined")
		document._selectionRectCounter = 0;

	// To produce clipping
	this.innerWrapperElement = document.createElement("div");
	this.innerWrapperElement.style.position = 'absolute';
	this.innerWrapperElement.style.left = '0px';
	this.innerWrapperElement.style.top = '0px';
	this.innerWrapperElement.style.width = parent_node.scrollWidth + "px";
	this.innerWrapperElement.style.height = parent_node.scrollHeight + "px";
	this.innerWrapperElement.style.overflow = 'hidden';
	this.innerWrapperElement.style.cursor = 'crosshair';
	this.wrapperElement.appendChild(this.innerWrapperElement);

	this.divId = "selectonrect_" + document._selectionRectCounter++;
	this.divElm = this.createDiv(this.divId, 1000, 'selectionRect', 'move', 'move');

	// Create opacity divs
	if (this.opacity) {
		this.opaLeftDiv = this.createDiv(this.divId + "_l", 999, 'opacityRect', '', '');
		this.opaRightDiv = this.createDiv(this.divId + "_r", 999, 'opacityRect', '', '');
		this.opaTopDiv = this.createDiv(this.divId + "_t", 999, 'opacityRect', '', '');
		this.opaBottomDiv = this.createDiv(this.divId + "_b", 999, 'opacityRect', '', '');
	}

	// Create resize divs
	if (this.resize) {
		this.resizeTopLeftDiv = this.createDiv(this.divId + "_resize_tl", 1001, 'resizeRect', 'nw-resize', 'nw-resize');
		this.resizeTopDiv = this.createDiv(this.divId + "_resize_t", 1001, 'resizeRect', 'n-resize', 'n-resize');
		this.resizeTopRightDiv = this.createDiv(this.divId + "_resize_tr", 1001, 'resizeRect', 'ne-resize', 'ne-resize');
		this.resizeMiddleLeftDiv = this.createDiv(this.divId + "_resize_ml", 1001, 'resizeRect', 'w-resize', 'w-resize');
		this.resizeMiddleRightDiv = this.createDiv(this.divId + "_resize_mr", 1001, 'resizeRect', 'e-resize', 'e-resize');
		this.resizeBottomLeftDiv = this.createDiv(this.divId + "_resize_bl", 1001, 'resizeRect', 'sw-resize', 'sw-resize');
		this.resizeBottomDiv = this.createDiv(this.divId + "_resize_b", 1001, 'resizeRect', 's-resize', 's-resize');
		this.resizeBottomRightDiv = this.createDiv(this.divId + "_resize_br", 1001, 'resizeRect', 'se-resize', 'se-resize');
	}

	// Add events
	this.addEvent(this.wrapperElement, "mousedown", this.eventDispatcher);
	this.addEvent(document, "mouseup", this.eventDispatcher);
	this.addEvent(document, "mousemove", this.eventDispatcher);
	this.addEvent(document, "keydown", this.eventDispatcher);
	this.addEvent(document, "keyup", this.eventDispatcher);
	this.addEvent(this.wrapperElement, "DOMMouseScroll", this.eventDispatcher);

	// Add to rects
	if (typeof(document._selectionRects) == "undefined")
		document._selectionRects = new Array();

	document._selectionRects[document._selectionRects.length] = this;
	document._selectionAction = "";

	if (!document._selectionThread) {
		window.setTimeout(this.threadDispatcher, 10);
		document._selectionThread = true;
	}

	this.update();
};

SelectionRect.prototype.setVisible = function(state) {
	this.visible = state;
	this.update();
};

SelectionRect.prototype.createDiv = function(id, z_index, class_name, cursor, action) {
	var div = document.createElement("div");

	div.id = id;
	div.style.position = 'absolute';
	div.style.left = '0px';
	div.style.top = '0px';
	div.style.zIndex = z_index;
	div.style.lineHeight = '1px';
	div.style.overflow = 'hidden';
	div.style.display = 'none';
	div.style.cursor = cursor;
	div.className = class_name;
	div._action = action;
	div.onmousedown = this.setAction;

	if (this.isMSIE)
		div.innerHTML = '<img _action="' + action + '" src="themes/default/images/spacer.gif" style="width: 100%; height: 100%" />';

	this.innerWrapperElement.appendChild(div);

	return div;
};

SelectionRect.prototype.setAction = function(e) {
	e = typeof(e) == "undefined" ? window.event : e;

	var elm = e.srcElement ? e.srcElement : e.target;

	document._selectionAction = elm._action;
};

SelectionRect.prototype.getAbsPosition = function(node) {
	var pos = new Object();

	pos.absLeft = pos.absTop = 0;

	var parentNode = node;
	while (parentNode) {
		pos.absLeft += parentNode.offsetLeft;
		pos.absTop += parentNode.offsetTop;

		parentNode = parentNode.offsetParent;
	}

	return pos;
};

SelectionRect.prototype.onSelection = function(selection, rectange) {
};

SelectionRect.prototype.setBounderies = function(x1, y1, x2, y2) {
	this.minX = x1;
	this.minY = y1;
	this.maxX = x2;
	this.maxY = y2;
};

SelectionRect.prototype.setRect = function(x, y, width, height) {
	// Handle bounderies
	if (this.minX != null) {
		x = x < this.minX ? this.minX : x;
		y = y < this.minY ? this.minY : y;
		x = x > this.maxX ? this.maxX : x;
		y = y > this.maxY ? this.maxY : y;

		x2 = x + width;
		y2 = y + height;

		if (x2 > this.maxX) {
			if (this.width != width) {
				x = this.x;
				width = this.width;
			} else
				x -= x2 - this.maxX;
		}

		if (y2 > this.maxY) {
			if (this.height != height) {
				y = this.y;
				height = this.height;
			} else
				y -= y2 - this.maxY;
		}
	}

	if (this.fixedProps) {
		chk = width < height;
		width = chk ? width : height;
		height = chk ? width : height;
	}

	this.x = x;
	this.y = y;
	this.width = width;
	this.height = height;

	if (this.width == 0)
		this.width = 1;

	if (this.height == 0)
		this.height = 1;

	this.update();
};

SelectionRect.prototype.getRect = function() {
	x = this.x;
	y = this.y;
	width = this.width;
	height = this.height;

	// Fix negative selection
	if (width < 0) {
		width = Math.abs(width);
		x = x - width;
	}

	// Fix negative selection
	if (height < 0) {
		height = Math.abs(height);
		y = y - height;
	}

	return {x : x, y : y, width : width, height : height};
};

SelectionRect.prototype.update = function() {
	var x, y, width, height;

	if (!this.divElm || this.x == null)
		return;

	var r = this.getRect();

	// Dispatch onselection
	if (this.onSelection != null)
		this.onSelection(this, r);

	this.setDivRect(this.divElm, r.x, r.y, r.width, r.height);

	// Position opacity divs
	if (this.opacity) {
		this.setDivRect(this.opaTopDiv, 0, 0, this.maxX, r.y, false);
		this.setDivRect(this.opaLeftDiv, 0, r.y, r.x, r.height, false);
		this.setDivRect(this.opaRightDiv, r.x + r.width, r.y, this.maxX - r.x - r.width, r.height, 0);
		this.setDivRect(this.opaBottomDiv, 0, r.y + r.height, this.maxX, this.maxY - r.y - r.height, 0);
	}

	// Position resize divs
	if (this.resize) {
		this.setDivRect(this.resizeTopLeftDiv, r.x-3, r.y-3, 7, 7);
		this.setDivRect(this.resizeTopDiv, r.x+Math.round(r.width/2)-3, r.y-3, 7, 7);
		this.setDivRect(this.resizeTopRightDiv, r.x+r.width-3, r.y-3, 7, 7);
		this.setDivRect(this.resizeMiddleLeftDiv, r.x-3, r.y+Math.round(r.height/2)-3, 7, 7);
		this.setDivRect(this.resizeMiddleRightDiv, r.x+r.width-3, r.y+Math.round(r.height/2)-3, 7, 7);
		this.setDivRect(this.resizeBottomLeftDiv, r.x-3, r.y + r.height - 3, 7, 7);
		this.setDivRect(this.resizeBottomDiv, r.x+Math.round(r.width/2)-3, r.y + r.height - 3, 7, 7);
		this.setDivRect(this.resizeBottomRightDiv, r.x+r.width-3, r.y + r.height - 3, 7, 7);
	}
};

SelectionRect.prototype.setDivRect = function(elm, x, y, w, h, border) {
	if (typeof(border) == "undefined")
		border = 2;

	w = this.isGecko ? (w - border) : w;
	h = this.isGecko ? (h - border) : h;

	if (w < 0)
		w = 0;

	if (h < 0)
		h = 0;

	elm.style.display = 'none';
	elm.style.left = x + "px";
	elm.style.top = y + "px";
	elm.style.width = w + "px";
	elm.style.height = h + "px";
	elm.style.display = 'block';

	if (this.visible)
		elm.style.display = 'block';
	else
		elm.style.display = 'none';
};

SelectionRect.prototype.addEvent = function(obj, name, handler) {
	if (this.isMSIE) {
		obj.attachEvent("on" + name, handler);
	} else
		obj.addEventListener(name, handler, false);
};

SelectionRect.prototype.cancelEvent = function(e) {
	if (this.isMSIE) {
		e.returnValue = false;
		e.cancelBubble = true;
	} else
		e.preventDefault();
};

SelectionRect.prototype.threadDispatcher = function() {
	var rects = document._selectionRects;
	for (var i=0; i<rects.length; i++)
		rects[i].run();

	window.setTimeout(SelectionRect.prototype.threadDispatcher, 10);
};

SelectionRect.prototype.eventDispatcher = function(e) {
	e = typeof(e) == "undefined" ? window.event : e;

	var rects = document._selectionRects;
	for (var i=0; i<rects.length; i++) {
		if (!rects[i].visible)
			continue;

		switch (e.type) {
			case "mousedown":
				rects[i].mouseDownHandler(e);
				break;

			case "mouseup":
				rects[i].mouseUpHandler(e);
				break;

			case "mousemove":
				rects[i].mouseMoveHandler(e);
				break;

			case "keydown":
				rects[i].keyDownHandler(e);
				break;

			case "keyup":
				rects[i].keyUpHandler(e);
				break;

			case "DOMMouseScroll":
				// Fix scrollwheel
				var st = e.currentTarget.scrollTop + (e.detail * 12);
				e.currentTarget.scrollTop = st < 0 ? 0 : st;
				e.preventDefault();
				break;
		}
	}
};

SelectionRect.prototype.setSelectionColor = function(color) {
	this.selectionColor = color;

	this.divElm.style.borderColor = color;
	this.resizeTopLeftDiv.style.borderColor = color;
	this.resizeTopDiv.style.borderColor = color;
	this.resizeTopRightDiv.style.borderColor = color;
	this.resizeMiddleLeftDiv.style.borderColor = color;
	this.resizeMiddleRightDiv.style.borderColor = color;
	this.resizeBottomLeftDiv.style.borderColor = color;
	this.resizeBottomDiv.style.borderColor = color;
	this.resizeBottomRightDiv.style.borderColor = color;
};

SelectionRect.prototype.getSelectionColor = function() {
	return this.selectionColor;
};

SelectionRect.prototype.run = function() {
/*	if (this.mouseDown && this.mouseMoveX > this.eventMaxX)
		this.wrapperElement.scrollLeft += 1;

	if (this.mouseDown && this.mouseMoveY > this.eventMaxY)
		this.wrapperElement.scrollTop += 1;*/
};

SelectionRect.prototype.getMouseX = function(e) {
	return (this.isMSIE ? e.x + this.wrapperElement.scrollLeft : e.pageX + this.wrapperElement.scrollLeft) - this.wrapperPos.absLeft;
};

SelectionRect.prototype.getMouseY = function(e) {
	return (this.isMSIE ? e.y + this.wrapperElement.scrollTop : e.pageY + this.wrapperElement.scrollTop) - this.wrapperPos.absTop;
};

SelectionRect.prototype.mouseDownHandler = function(e) {
	var mx = this.getMouseX(e), my = this.getMouseY(e);

	mx -= this.isMSIE ? 2 : 0;
	my -= this.isMSIE ? 2 : 0;

	// Not for us
	if (this.minX != null && (mx < this.minX || mx > this.eventMaxX + this.wrapperElement.scrollLeft || my < this.minY || my > this.eventMaxY + this.wrapperElement.scrollTop))
		return;

	this.mouseDown = true;

	// Gets undefined in MSIE sometimes
	if (typeof(mx) != "undefined" && typeof(my) != "undefined") {
		var r = this.getRect();

		this.mouseDownX = mx;
		this.mouseDownY = my;
		this.mouseDownRect = r;

		this.action = document._selectionAction;

		switch (this.action) {
			case "nw-resize":
				this.mouseDownX = r.x;
				this.mouseDownY = r.y;
				break;

			case "n-resize":
				this.mouseDownX = r.x+Math.round(r.width/2);
				this.mouseDownY = r.y;
				break;

			case "ne-resize":
				this.mouseDownX = r.x+r.width;
				this.mouseDownY = r.y;
				break;

			case "w-resize":
				this.mouseDownX = r.x;
				this.mouseDownY = r.y+Math.round(r.height/2);
				break;

			case "e-resize":
				this.mouseDownX = r.x+r.width;
				this.mouseDownY = r.y+Math.round(r.height/2);
				break;

			case "sw-resize":
				this.mouseDownX = r.x;
				this.mouseDownY = r.y + r.height;
				break;

			case "s-resize":
				this.mouseDownX = r.x+Math.round(r.width/2);
				this.mouseDownY = r.y + r.height;
				break;

			case "se-resize":
				this.mouseDownX = r.x+r.width;
				this.mouseDownY = r.y + r.height;
				break;

			case "move":
				this.panDX = r.x - this.mouseDownX;
				this.panDY = r.y - this.mouseDownY;
				break;

			default:
				this.setRect(mx, my, 0, 0);
				this.divElm.style.display = 'none';
		}

		this.mouseDownDX = mx - this.mouseDownX;
		this.mouseDownDY = my - this.mouseDownY;
	}

	this.cancelEvent(e);
};

SelectionRect.prototype.mouseUpHandler = function(e) {
	this.mouseDown = false;
	this.action = "";
	this.divElm.style.cursor = "move";
	this.wrapperElement.style.cursor = "crosshair";

	document._selectionAction = "";

	this.cancelEvent(e);
};

SelectionRect.prototype.mouseMoveHandler = function(e) {
	var mx = this.getMouseX(e), my = this.getMouseY(e);

	mx -= this.isMSIE ? 1 : -1;
	my -= this.isMSIE ? 1 : -1;

	this.mouseMoveX = mx;
	this.mouseMoveY = my;

	if (!this.mouseDown)
		return;

	// Gets undefined in MSIE sometimes
	if (typeof(mx) != "undefined" && typeof(my) != "undefined") {
		var r = this.getRect();

		// Boundery check X, Y
		mx = mx < this.minX ? this.minX : mx;
		my = my < this.minY ? this.minY : my;

		// Fix within resize boxes
		mx -= this.mouseDownDX;
		my -= this.mouseDownDY;

		mdx = this.mouseDownX;
		mdy = this.mouseDownY;

		switch (this.action) {
			case "nw-resize":
				this.setRect(mx, my, this.mouseDownRect.width + (mdx - mx), this.mouseDownRect.height + (mdy - my));
				break;

			case "n-resize":
				this.setRect(this.x, my, this.width, this.mouseDownRect.height + (mdy - my));
				break;

			case "ne-resize":
				this.setRect(this.x, my, mx - this.x, this.mouseDownRect.height + (mdy - my));
				break;

			case "w-resize":
				this.setRect(mx, this.y, this.mouseDownRect.width + (mdx - mx), this.height);
				break;

			case "e-resize":
				this.setRect(this.x, this.y, mx - this.x, this.height);
				break;

			case "sw-resize":
				this.setRect(mx, this.y, this.mouseDownRect.width + (mdx - mx), my - this.y);
				break;

			case "s-resize":
				this.setRect(this.x, this.y, this.width, my - this.y);
				break;

			case "se-resize":
				this.setRect(this.x, this.y, mx - this.x, my - this.y);
				break;

			case "move":
				this.setRect(mx + this.panDX, my + this.panDY, r.width, r.height);
				break;

			default:
				this.setRect(this.x, this.y, mx - this.x, my - this.y);
		}

		this.divElm.style.cursor = this.action;
		this.wrapperElement.style.cursor = this.action;
	}

	this.cancelEvent(e);
};

SelectionRect.prototype.keyDownHandler = function(e) {
	this.fixedProps = e.shiftKey;
};

SelectionRect.prototype.keyUpHandler = function(e) {
	this.fixedProps = e.shiftKey;
};
