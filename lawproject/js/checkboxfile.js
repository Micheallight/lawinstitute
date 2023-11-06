function checkAll(obj, nameOfObj) {
	'use strict';
	let items = document.getElementById(nameOfObj).getElementsByTagName("input");
	let len;
	let i;
	for (i = 0, len = items.length; i < len; i += 1) {
		if (items.item(i).type && items.item(i).type === "checkbox") {       
			if (obj.checked) {
				items.item(i).checked = true;
			} else {
				items.item(i).checked = false;
			}       
		}
	}
}

function uncheckAll(nameOfObj) {
	'use strict';
	let item = document.getElementById(nameOfObj).getElementsByTagName("input")[0];
	item.checked = false;
}