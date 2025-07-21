const scrollToBottom = (id) => {
	const element = document.getElementById(id);
	element.scrollTop = element.scrollHeight;
 }

 const scrollToTop = (id) => {
	const element = document.getElementById(id);
	element.scrollTop = 0;
 }

 // Require jQuery
 const scrollSmoothlyToBottom = (id) => {
	const element = $(`#${id}`);
	element.animate({
	   scrollTop: element.prop("scrollHeight")
	}, 500);
 }

 // Require jQuery
 const scrollSmoothlyToTop = (id) => {
	$(`#${id}`).animate({
	   scrollTop: 0,
	}, 500);
 }