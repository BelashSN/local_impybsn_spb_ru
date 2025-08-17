$(document).ready(function () {
  $("form").submit(function (event) {
    event.preventDefault();
    $("#page_result").removeClass('page_error');

    var formData = {
      user_name: $("#user_name").val(),     
      user_last_name: $("#user_last_name").val(),
      user_second_name: $("#user_second_name").val(),
    };

    $.ajax({
      type: "POST",
      url: "dadata.php",
      data: formData,
      dataType: "json",
      encode: true,
      error: (stausXHR, exception) => {
        show_error(ajax_errors(stausXHR, exception));
      }
    })
    .done(function (result) {
      console.log(result); 

      if (typeof result['Error'] !== 'undefined'){
        let errDetail = !result['Detail'] ? '' : JSON.stringify(result['Detail'], null, '<br>');
        $("#page_result").html(
            '<p><strong>Ошибка:</strong></p>' 
            + '<p>' + result['Error'] + '<br>' + errDetail + '</p>'
        );
        return;
      }

      if (jQuery.type(result) !== 'array' || result.length !== 1 || jQuery.type(result[0]) !== 'object') {
        $("#page_result").html(
            '<p><strong>Ошибка:</p></strong>' 
            + '<p>Сервер вернул некорректный результат...</p>'
        );
        return;
      }

      for (let value of result) {
        $("#page_result").html(
            '<p><strong>Результат:</strong>' 
            + '</p><p>Полное имя: ' + value.result
            + '</p><p>Фамилия: ' + value.surname
            + '</p><p>Имя: ' + value.name
            + '</p><p>Отчество: ' + value.patronymic 
            + '</p><p>В лице: ' + value.result_genitive 
            + '</p><p>Кому: ' + value.result_dative 
            + '</p><p>Согласовано: ' + value.result_ablative + '</p>'
          );
      }
    });
  });
});

function json_replacer(value) {
  return value.replace(/[^\w\s]/gi, '');
};

function show_error(errValue) {
  $("#page_result").addClass('page_error');
  $("#page_result").html(
      '<p><strong>Ошибка: </strong></p>' + 
      '<p>' + errValue.errCode + '<br>' + errValue.errText + '</p>'
    );
};

function ajax_errors(stausXHR, exception) {
  errText = stausXHR.responseText;
  switch(stausXHR.status) {
    case 0: errText = 'Not connect. Verify Network.'; break;
    case 404: errText = 'Requested page not found.'; break;
    case 500: errText = 'Internal Server Error.'; break;
  };

  switch(exception) {
    case 'parsererror': errText = 'Requested JSON parse failed.'; break;
    case 'timeout': errText = 'Time out error.'; break;
    case 'abort': errText = 'Ajax request aborted.'; break;
  }; 

  return {'errCode': 'Error (' + stausXHR.status + ')', 'errText': errText};
};
