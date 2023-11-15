window.onscroll = function() { scrollFunction() };
window.on

function scrollFunction() {
	var toolbar = document.getElementById("toolbar");
	var logo = document.getElementById("logo");
	//var object = document.getElementsByClassName("object");
	var objectById = document.getElementById("objectLogout");
	var menuAnagrafiche = document.getElementById("menuAnagrafiche");
	if (document.body.scrollTop > 120 || document.documentElement.scrollTop > 120) {
		toolbar.style.top = 0;
		menuAnagrafiche.style.top = 55;
		logo.style.height = logo.style.width = 55;
		toolbar.style.borderRadius = '10px 10px 10px 10px';
		if (objectById.offsetWidth < 160){
			logo.style.display = 'none';
			logo.style.zIndex = 0;
		} else { 
			logo.style.display = 'block';
			logo.style.zIndex = 3;
		}
	} else {
		toolbar.style.borderRadius = '0px 0px 10px 10px';
		toolbar.style.top = 120 - document.body.scrollTop;
		menuAnagrafiche.style.top = 175 - document.body.scrollTop;
		logo.style.height = logo.style.width = 120 - document.body.scrollTop;

		logo.style.display = 'block';
		logo.style.zIndex = 3;
	}



}

function clickAnagraficheFunction() {
	var menuAnagrafiche = document.getElementById("menuAnagrafiche");
	if (menuAnagrafiche.style.display === 'flex') {
		menuAnagrafiche.style.display = 'none';
	} else {
		menuAnagrafiche.style.display = 'flex';
	}
}