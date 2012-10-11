// Mustis WebOS

state = {}

function poster(addr, data, cb) {
	if (!cb) cb = processResponse;

	if (state.uid) data.uid = state.uid;
	if (state.sid) data.sid = state.sid;
	$.post('backend/'+addr, data, cb, 'json');
}

function processResponse(resp) {
	loc = "div#body";
	if (resp.success) {
		if (resp.contents) {
			$(loc).html(resp.contents);
		}
		if (resp.data) {
			for (key in resp.data) {
				state[key] = resp.data[key];
			}
		}
	} else {
		$("div#error").html(resp.error.reason);
		$("div#error").fadeIn('fast').delay(5000).fadeOut('slow');
	}
}
