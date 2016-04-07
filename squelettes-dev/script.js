$( document ).ready(function() {

   $( "#vue-simple" ).click(function() {
		$(".liste-projets .logo").hide();
		$(".liste-projets .tag").hide();
	});
	$("#vue-complexe").click(function() {
		$(".liste-projets .logo").show();
		$(".liste-projets .tag").show();
	});

});
