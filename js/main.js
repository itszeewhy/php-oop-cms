$(function () {
  $("table .select_all").on("change", function () {
    var checkbox = $(this).parents().find("table .select_this");
    if (this.checked) {
      checkbox.prop("checked", true);
    } else {
      checkbox.prop("checked", false);
    }
  });

  var param = location.search;
  if (param != "") {
    var param_vals = param.split("=");
    if (param_vals[0] == "?page") {
      var pages = $(".pagination li a");
      pages.each(function () {
        if (this.innerText == param_vals[1]) {
          $(this).addClass("active");
        }
      });
    } else {
      console.log("c");
    }
  }

  var limit = 0;
  $('#showUser').on('click', function(){
    limit++;
    $('#users').load('ajax/fetchuser.php', {
      limit: limit
    });
  });


  

});
