$(document).ready(function() {
  $("#form").on('submit', function(event) {
    event.preventDefault();

    var $myform = $("#form");
    var datatosend = $myform.serialize();

      $.post("/new", datatosend, function(d) {
        console.log(d);
      });

  });
})
