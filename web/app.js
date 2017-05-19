$(document).ready(function() {
  function ajaxCall() {
    $.ajax({
      type: "POST",
      url: "{{ path(' _new ') }}",
      dataType: 'json',
      data: {
        "id":"10",
        "product": "Pomme",
        "quantity": "5"
      },
      success: function(d) {
        console.log(d);
      }
    })
  }
})
