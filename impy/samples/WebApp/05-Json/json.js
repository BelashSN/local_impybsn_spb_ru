$(document).ready(function() {
    $('.tabContent').css('display', 'none');
    $('#ResultRequest').css('display', 'block');

    $('.tablinks').on('click', (e) => {
        $('.tablinks').removeClass('active');
        $('.tabContent').css('display', 'none');

        $(e.target).addClass('active');
        $('#' + e.target.name + 'Request').css('display', 'block');
    });

    $('#myForm').submit(function (e) { 
        e.preventDefault();    
        var form_data = $(this).serialize(); 

        $.ajax({
            type: 'POST', 
            url: 'json.php',
            data: form_data,
            encode: true,
            success: function (resJson) {
                let resData = JSON.parse(resJson);
                $('#ParamRequest').html('<pre>' + resData['ParamRequest'] + '</pre>');
                $('#ResultRequest').html('<pre>' + resData['ResultRequest'] + '</pre>');
            }
        });
    });
})