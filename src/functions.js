$(document).ready(function(){
	$("#skill").on("show.bs.modal", function(event){
		// Place the returned HTML into the selected element
		$(this).find(".modal-body-skill").load("/skillaenderung.php");
	});
	
	$("#project").on("show.bs.modal", function(event){
		// Place the returned HTML into the selected element
		$(this).find(".modal-body-project").load("/projects.php");
	});
});