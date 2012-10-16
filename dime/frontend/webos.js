// Mustis WebOS

var state = {
	insertLoc: 'div#body',
}

function poster(addr, data, cb) {
	if (!cb) cb = processResponse;

	for (key in state) {
		if (!data[key])
			data[key] = state[key];
	}
	$.post('backend/'+addr, data, function (resp) {
		cb(resp);
		newContent();
	}, 'json');
}

function processResponse(resp) {
	if (resp.success) {
		if (resp.data) {
			for (key in resp.data) {
				state[key] = resp.data[key];
			}
		}
		if (resp.contents) {
			$(state.insertLoc).append(resp.contents);
		}
	} else {
		$("div#error").append('<p>'+resp.error.reason+'</p>');
		$("div#error").slideDown(400);
	}
}
function processAppMenu(resp) {
	if (resp.success) {
		$("ul#appmenu").html(resp.contents);
	} else {
		$("div#error").append('<p>'+resp.error.reason+'</p>');
		$("div#error").slideDown(400);
	}
}
function processSystemMenu(resp) {
	if (resp.success) {
		$("ul#systemmenu").html(resp.contents);
	} else {
		$("div#error").append('<p>'+resp.error.reason+'</p>');
		$("div#error").slideDown(400);
	}
}

function newWindow(id, title) {
	$("div#body").append('<div id="'+id+'" class="appwindow"><div class="windowtitle"><a href="javascript:$(\'#'+id+'\').remove();void(0);">'+title+'</a></div><div class="windowbody">&nbsp;</div></div>');
}

function closeMenu() {
	$(".menu").each(function () {
		if ($(this).css("display") != "none") {
			$(this).menu("destroy");
			$(this).hide();
		}
	});
}

function newContent() {
	$(".error").click(function () {
		$(this).slideUp(400);
		$(this).html('<small><em>click to close</em></small>');
	});
	$(".appwindow").draggable();
}

$(document).ready(newContent);
