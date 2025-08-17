$(document).ready(function () { 
  var secret;  
  $.get("../security_dadata.txt", (data) => {  secret = data; });
  var url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address?ip=";

  $("form").submit(function (event) {
    event.preventDefault();
    $("#result").slideUp(500);   
    
    var formData = { query: $("#ip").val(), };

    $.ajax({
      type: "GET",
      url: url + formData.query,
      beforeSend: function(xhr) { xhr.setRequestHeader("Authorization", 
        "Token " + JSON.parse(atob(secret, true)).token)  },
      data: '',
      dataType: "json",
      encode: true,
    }) 

    .done(function (response) {
      console.log(response);
      //----------
      if(response.location === null) {
        $("#general").html( 'API Dafata не содержит информацию об IP-адресе: ' + formData.query);
      }
      else {
        $("#general").html(response.location.value + '<br>'); 
        $("#advansed").html(JSON.stringify(response.location.data, null, '<br>')); 
      }  
    })

    .fail(function(xhr) {
      console.log(xhr.responseJSON);
      $("#general").html(
        'Ошибка '  + xhr.status + ': <br>' + xhr.responseJSON.message
      )
    });

    $("#result").slideDown(500);   
  });
});

