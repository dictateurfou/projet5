$( document ).ready(function() {
  	$("#register-switch").click(function() {
  		$("#connect-form").hide();
  		$("#register-form").show();
	});

	$("#connection-switch").click(function() {
  		$("#register-form").hide();
  		$("#connect-form").show();
	});
});