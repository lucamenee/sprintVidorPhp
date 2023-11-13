window.onscroll = function() { scrollFunction() };

function scrollFunction() {
	var toolbar = document.getElementById("toolbar");
	var logo = document.getElementById("logo");
	if (document.body.scrollTop > 120 || document.documentElement.scrollTop > 120) {
		toolbar.style.top = 0;
		logo.style.height = logo.style.width = 55;
	} else {
		toolbar.style.top = 120 - document.body.scrollTop;
		logo.style.height = logo.style.width = 120 - document.body.scrollTop;
	}
}