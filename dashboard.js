// Update the table based on PHP variables
$(document).ready(function () {
    var currentDateTime = new Date();

    repeat()

    $("#ledOn").click(function () {
        var formattedDateTime = currentDateTime.toLocaleString();

        var data = {
            nome: "LedArduino",
            valor: 1,
            hora: formattedDateTime
        };

        // Realizar a solicitação AJAX
        $.ajax({
            url: "api/api.php",
            type: "POST",
            data: data,
            success: function (response) {
                // Manipular a resposta da API
                console.log(response);
            },
            error: function (xhr, status, error) {
                // Lidar com erros
                console.log("Erro na solicitação:", error);
            }
        });
    });

    $("#ledOff").click(function () {
        var formattedDateTime = currentDateTime.toLocaleString();

        var data = {
            nome: "LedArduino",
            valor: 0,
            hora: formattedDateTime
        };

        // Realizar a solicitação AJAX
        $.ajax({
            url: "api/api.php",
            type: "POST",
            data: data,
            success: function (response) {
                // Manipular a resposta da API
                console.log(response);
            },
            error: function (xhr, status, error) {
                // Lidar com erros
                console.log("Erro na solicitação:", error);
            }
        });
    });

    $("#buzzerOn").click(function () {
        var formattedDateTime = currentDateTime.toLocaleString();

        var data = {
            nome: "BuzzerRaspberry",
            valor: 1,
            hora: formattedDateTime
        };

        // Realizar a solicitação AJAX
        $.ajax({
            url: "api/api.php",
            type: "POST",
            data: data,
            success: function (response) {
                // Manipular a resposta da API
                console.log(response);
            },
            error: function (xhr, status, error) {
                // Lidar com erros
                console.log("Erro na solicitação:", error);
            }
        });
    });

    $("#buzzerOff").click(function () {
        var formattedDateTime = currentDateTime.toLocaleString();

        var data = {
            nome: "BuzzerRaspberry",
            valor: 0,
            hora: formattedDateTime
        };

        // Realizar a solicitação AJAX
        $.ajax({
            url: "api/api.php",
            type: "POST",
            data: data,
            success: function (response) {
                // Manipular a resposta da API
                console.log(response);
            },
            error: function (xhr, status, error) {
                // Lidar com erros
                console.log("Erro na solicitação:", error);
            }
        });
    });

    setInterval(repeat, 1000);

});



function repeat() {

    $('.col-sm-4').each(function () {
        var col = $(this);

        var sensorName = col.find('.card-header strong').text().trim().split(':')[0];
        var sensorValue;
        var sensorTime;
        var estado;

        if ($.trim(sensorName).length > 0 && sensorName.toLowerCase() != 'imagem') {
            // GET the value
            $.ajax({
                url: 'api/files/' + sensorName.toLowerCase() + '/valor.txt' + '?timestamp=' + Date.now(),
                method: 'GET',
                dataType: 'text',
                success: function (data) {
                    sensorValue = data;

                    // GET the timestamp
                    $.ajax({
                        url: 'api/files/' + sensorName.toLowerCase() + '/hora.txt' + '?timestamp=' + Date.now(),
                        method: 'GET',
                        dataType: 'text',
                        success: function (data) {
                            sensorTime = data;


                            // Sensor de Temperatura
                            if (sensorName == 'Temperatura') {

                                col.find('.card-header strong').text(sensorName + ': ' + sensorValue + 'ºC');

                                if (sensorValue > 20) {
                                    col.find('.card-body').html("<img class='card-image' src='imagens/temperature-high.png' alt=''>");
                                }
                                else {
                                    if (sensorValue < 10) {
                                        col.find('.card-body').html("<img class='card-image' src='imagens/temperature-low.png' alt=''>");
                                    }
                                    else {
                                        col.find('.card-body').html("<img class='card-image' src='imagens/temperature-normal.png' alt=''>");
                                    }
                                }
                            }

                            // Sensor de Humidade
                            if (sensorName == 'Humidade') {
                                col.find('.card-header strong').text(sensorName + ': ' + sensorValue + '%');

                                if (sensorValue > 50) {
                                    col.find('.card-body').html("<img class='card-image' src='imagens/humidity-high.png' alt=''>");
                                }
                                else {
                                    col.find('.card-body').html("<img class='card-image' src='imagens/humidity-low.png' alt=''>");
                                }
                            }

                            // Sensor de Luz
                            if (sensorName == 'Luz') {
                                if(sensorValue == "1")
                                {
                                    estado = "Dia"
                                    col.find('.card-body').html("<img class='card-image' src='imagens/sol.png' alt=''>");
                                }
                                else
                                {
                                    estado = "Noite"
                                    col.find('.card-body').html("<img class='card-image' src='imagens/lua.png' alt=''>");
                                }
                                    
                                col.find('.card-header strong').text(sensorName + ': ' + estado);
                            }

                            // Ventilador
                            if (sensorName == 'Ventilador') {
                                if (sensorValue == "1") {
                                    estado = "Ativo";
                                    col.find('.card-body').html("<img class='card-image' src='imagens/ventilador_on.gif' alt=''>");
                                } else {
                                    estado = "Desligado"
                                    col.find('.card-body').html("<img class='card-image' src='imagens/ventilador_off.png' alt=''>");
                                }

                                col.find('.card-header strong').text(sensorName + ': ' + estado);
                            }

                            // Humidificador
                            if (sensorName == 'Humidificador') {
                                if (sensorValue == "1") {
                                    estado = "Ativo";
                                    col.find('.card-body').html("<img class='card-image' src='imagens/humidifier_on.png' alt=''>");
                                } else {
                                    estado = "Desligado"
                                    col.find('.card-body').html("<img class='card-image' src='imagens/humidifier_off.png' alt=''>");
                                }
                                col.find('.card-header strong').text(sensorName + ': ' + estado);
                            }

                            // Aquecedor
                            if (sensorName == 'Aquecedor') {
                                if (sensorValue == "1") {
                                    estado = "Ativo";
                                    col.find('.card-body').html("<img class='card-image' src='imagens/heater_on.png' alt=''>");
                                } else {
                                    estado = "Desligado"
                                    col.find('.card-body').html("<img class='card-image' src='imagens/heater_off.png' alt=''>");
                                }
                                col.find('.card-header strong').text(sensorName + ': ' + estado);
                            }

                            // LedArduino
                            if (sensorName == 'LedArduino') {
                                if (sensorValue == "1") {
                                    estado = "Ativo";
                                    col.find('.card-body').html("<img class='card-image' src='imagens/light-on.png' alt=''>");
                                } else {
                                    estado = "Desligado"
                                    col.find('.card-body').html("<img class='card-image' src='imagens/light-off.png' alt=''>");
                                }
                                col.find('.card-header strong').text(sensorName + ': ' + estado);
                            }

                            // Led
                            if (sensorName == 'Led') {
                                if (sensorValue == "1") {
                                    estado = "Ativo";
                                    col.find('.card-body').html("<img class='card-image' src='imagens/light-on.png' alt=''>");
                                } else {
                                    estado = "Desligado"
                                    col.find('.card-body').html("<img class='card-image' src='imagens/light-off.png' alt=''>");
                                }
                                col.find('.card-header strong').text(sensorName + ': ' + estado);
                            }

                            // BuzzerRaspberry
                            if (sensorName == 'BuzzerRaspberry') {
                                if (sensorValue == "1") {
                                    estado = "Ativo";
                                    col.find('.card-body').html("<img class='card-image' src='imagens/light-on.png' alt=''>");
                                } else {
                                    estado = "Desligado"
                                    col.find('.card-body').html("<img class='card-image' src='imagens/light-off.png' alt=''>");
                                }
                                col.find('.card-header strong').text(sensorName + ': ' + estado);
                            }


                            col.find('.card-footer').html('<b>Atualização:</b> ' + sensorTime + "<?php if ($_SESSION['tipo_user'] == 'admin'){ ?>- <a href='historico.php?nome=<?php echo $nome_led_arduino ?>'>Histórico</a> <?php}?>");

                            sensorName = 0;
                            sensorValue = 0;
                            estado = "";
                        },
                        error: function (xhr, status, error) {
                            console.log('Error:', error);
                        }
                    });
                },
                error: function (xhr, status, error) {

                    console.log('Error:', error, xhr, status);
                }
            });
        }
            

    });


    $('tbody tr').each(function () {
        var row = $(this);

        var sensorName = row.find('.device-nome').text().trim();
        var sensorValue;
        var sensorTime;
        var estado;



        if ($.trim(sensorName).length > 0) {
            // GET the value
            $.ajax({
                url: 'api/files/' + sensorName.toLowerCase() + '/valor.txt' + '?timestamp=' + Date.now(),
                method: 'GET',
                dataType: 'text',
                success: function (data) {
                    sensorValue = data;

                    // GET the timestamp
                    $.ajax({
                        url: 'api/files/' + sensorName.toLowerCase() + '/hora.txt' + '?timestamp=' + Date.now(),
                        method: 'GET',
                        dataType: 'text',
                        success: function (data) {
                            sensorTime = data;



                            row.find('.device-hora').text(sensorTime);
                            row.find('.device-estado').text("aqui");


                            // Temperatura
                            if (sensorName == 'Temperatura') {
                                row.find('.device-valor').text(sensorValue + 'ºC');

                                if (sensorValue > 30)
                                    row.find('.device-estado').html("<span class='badge text-bg-danger'>Elevada</span>");
                                else
                                    if (sensorValue < 10)
                                        row.find('.device-estado').html("<span class='badge text-bg-warning'>Baixa</span>");
                                    else
                                        row.find('.device-estado').html("<span class='badge text-bg-success'>Normal</span>");
                            }
                            else {
                                // Humidade
                                if (sensorName == 'Humidade') {
                                    row.find('.device-valor').text(sensorValue + '%');

                                    if (sensorValue > 50)
                                        row.find('.device-estado').html("<span class='badge text-bg-success'>Normal</span>");
                                    else
                                        row.find('.device-estado').html("<span class='badge text-bg-danger'>Baixa</span>");
                                }
                                else {
                                    // Luz
                                    if (sensorName == 'Luz') {
                                        if (sensorValue == "1") {
                                            estado = "Dia";
                                        } else {
                                            estado = "Noite"
                                        }
                                        row.find('.device-valor').text(estado);
                                        if (sensorValue == 1)
                                            row.find('.device-estado').html("<span class='badge text-bg-warning'>Dia</span>");
                                        else
                                            row.find('.device-estado').html("<span class='badge text-bg-dark'>Noite</span>");
                                    }
                                    else {
                                        // Atuadores
                                        if (sensorValue == 1) {
                                            estado = "Ativo";
                                            row.find('.device-estado').html("<span class='badge text-bg-success'>" + estado + "</span>");
                                        }
                                        else {
                                            estado = "Desligado";
                                            row.find('.device-estado').html("<span class='badge text-bg-secondary'>" + estado + "</span>");
                                        }

                                        row.find('.device-valor').text(estado);

                                    }
                                }
                            }

                        },
                        error: function () {
                            console.log('Error fetching timestamp for ' + sensorName);
                        }
                    });
                },
                error: function () {
                    console.log('Error fetching value for ' + sensorName);
                }
            });
        }
    });


}