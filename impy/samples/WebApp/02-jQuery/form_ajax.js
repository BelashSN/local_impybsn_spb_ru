$(document).ready(function () {
  $("form").submit(function (event) {
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
    }).done(function (result) {
      console.log(result); 

      if (typeof result['Error'] !== 'undefined'){
        $("#result").html(
            '<p>Ошибка:</p>' 
            + '<p>' + result['Error'] + '</p>'
        );
        return;
      }

      if (jQuery.type(result) !== 'array') {
        $("#result").html(
            '<p>Ошибка:</p>' 
            + '<p>Сервер вернул некорректный результат...</p>'
        );
        return;
      }

      if (result.length !== 1){
        $("#result").html(
            '<p>Ошибка:</p>' 
            + '<p>Сервер вернул некорректный результат...</p>'
        );
        return;
      }

      if (jQuery.type(result[0]) !== 'object'){
        $("#result").html(
            '<p>Ошибка:</p>' 
            + '<p>Сервер вернул некорректный результат...</p>'
        );
        return;
      }

      for (let value of result) {
        $("#result").html(
            '<p>Результат:' 
            + '</p><p>Полное имя: ' + value.result
            + '</p><p>Фамилия: ' + value.surname
            + '</p><p>Имя: ' + value.name
            + '</p><p>Отчество: ' + value.patronymic 
            + '</p><p>В лице: ' + value.result_genitive 
            + '</p><p>Кому: ' + value.result_dative 
            + '</p><p>Согласовано: '  + value.result_ablative 
            + '</p>'
          );
      }

    });

    event.preventDefault();
  });
});
