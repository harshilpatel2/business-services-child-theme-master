jQuery(document).ready(function($) {

if ( $( "#business-page" ).length ) {
  /*CONTENT TYPE SORTER*/
  //get the content from the page
  var div = document.getElementById("dom-target");
  var text_data = div.textContent;
  var content_types = text_data.split(" ");

                                      //stop at last (empty) space
  for (i = 0; i < content_types.length - 1; i++) {
    var content = "." + content_types[i];
    //wrap similar content type classes together for styling
      $("#must-have " +  content).wrapAll( "<div class='" + content_types[i] + "-wrapper" + "' />");
      $("#might-need " + content).wrapAll( "<div class='" + content_types[i] + "-wrapper" + "' />");

  }
}
$("address").hide().each(function(){
    var address = $(this).text().replace(/\,/g, ' '); // get rid of commas
    var url = address.replace(/\ /g, '%20'); // convert address into approprite URI for google maps
	$(this).wrap('<a href="http://maps.google.com/maps?q=' + url + '" target="_blank">Directions</a>');
	address.remove();
	});
});
