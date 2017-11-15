$('#search-bar').on('input', function(){
  $.ajax({
    url: "/getproductbykeyword",
    data: {
      search: $(this).value
    },
    dataType: json,
    success: function(data){
      console.log(data);
    },
    error: function(){
      console.log("erreuuur");
    },
    method: "POST"
  });
});
