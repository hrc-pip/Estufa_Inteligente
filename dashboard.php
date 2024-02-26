<?php

session_start();

// veirifica se o user esta logado
if (!isset($_SESSION['username'])) {
    header("refresh:5;url=index.php");
    die("Acesso restrito. ");
}

?>


<?php

/* TO DO 
- 3 utilizadores com 3 privilégios diferentes.
*/

// receber os valores dos ficheiros dos sensores/atuadores

//Temperatura
$valor_temperatura = file_get_contents("api/files/Temperatura/valor.txt");
$hora_temperatura = file_get_contents("api/files/Temperatura/hora.txt");
$nome_temperatura = file_get_contents("api/files/Temperatura/nome.txt");

//Humidade
$valor_humidade = file_get_contents("api/files/Humidade/valor.txt");
$hora_humidade = file_get_contents("api/files/Humidade/hora.txt");
$nome_humidade = file_get_contents("api/files/Humidade/nome.txt");

//Led
$valor_led = file_get_contents("api/files/Led/valor.txt");
$hora_led = file_get_contents("api/files/Led/hora.txt");
$nome_led = file_get_contents("api/files/Led/nome.txt");

//LedArduino
$valor_led_arduino = file_get_contents("api/files/LedArduino/valor.txt");
$hora_led_arduino = file_get_contents("api/files/LedArduino/hora.txt");
$nome_led_arduino = file_get_contents("api/files/LedArduino/nome.txt");

//BuzzerRaspberry
$valor_buzzer_rasp = file_get_contents("api/files/BuzzerRaspberry/valor.txt");
$hora_buzzer_rasp = file_get_contents("api/files/BuzzerRaspberry/hora.txt");
$nome_buzzer_rasp = file_get_contents("api/files/BuzzerRaspberry/nome.txt");

//Aquecedor
$valor_aquecedor = file_get_contents("api/files/Aquecedor/valor.txt");
$hora_aquecedor = file_get_contents("api/files/Aquecedor/hora.txt");
$nome_aquecedor = file_get_contents("api/files/Aquecedor/nome.txt");


//Ventilador
$valor_vent = file_get_contents("api/files/Ventilador/valor.txt");
$hora_vent = file_get_contents("api/files/Ventilador/hora.txt");
$nome_vent = file_get_contents("api/files/Ventilador/nome.txt");


//Luz
$valor_luz = file_get_contents("api/files/Luz/valor.txt");
$hora_luz = file_get_contents("api/files/Luz/hora.txt");
$nome_luz = file_get_contents("api/files/Luz/nome.txt");

//Led
$valor_humidificador = file_get_contents("api/files/Humidificador/valor.txt");
$hora_humidificador = file_get_contents("api/files/Humidificador/hora.txt");
$nome_humidificador = file_get_contents("api/files/Humidificador/nome.txt");

?>

<!doctype html>
<html lang="en" style="height: auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Estufa Inteligente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=<?php echo time() ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="dashboard.js?v=<?php echo time() ?>"></script>
</head>

<body class="bg-imageDashboard">

    <nav class=" navbar navbar-light navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Estufa Inteligente</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="graph.php">Graph</a>
                    </li>
                    <?php
                    // verifica se o utilizador tem permissões para ver o histórico dos sensores/atuadores
                    if ($_SESSION['tipo_user'] == "admin") {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Histórico</a>
                        </li>
                    <?php
                    }
                    ?>

                </ul>

                <a class="btn btn-outline-secondary" href="logout.php">Logout</a>

            </div>
        </div>
    </nav>

    <br>
    <div class="container">
        <div class="card">
            <div class="card-body" style="display: inline;">
                <img src="imagens/logo_estufa.png" alt="" class="float-sm-end imagemLogo">
                <img src="imagens/estg.png" alt="" class="float-sm-end" style="width: 300px;">
                <h1 class="card-title"> <b>Servidor IoT - Estufa Inteligente</b> </h1>
                <span class="card-text">Bem vindo <b>
                        <?php echo $_SESSION['username']; ?>
                    </b>,</span>
                <p>Aqui pode monitorizar o estado da sua estufa e outras<br>
                    informações relevantes para manutenção das suas plantas &#127793;</p>
            </div>
        </div>
    </div>

    <br>

    <div class="container">
        <div class="row">

            <!-- Temperatura -->
            <div class="col-sm-4">
                <div class="card text-center card-margin">
                    <div class="card-header sensorTemp"><strong>
                            <?php echo $nome_temperatura ?>:
                            <?php echo $valor_temperatura ?>ºC
                        </strong></div>
                    <div class="card-body">

                        <?php
                        // tendo em conta que a temperatura típica de uma estufa varia entre 10 e 20°C
                        if ($valor_temperatura > 20) {
                        ?>
                            <img src="imagens/temperature-high.png" alt="">
                        <?php
                        } elseif ($valor_temperatura < 10) {
                        ?>
                            <img src="imagens/temperature-low.png" alt="">
                        <?php
                        } else {
                        ?>
                            <img src="imagens/temperature-normal.png" alt="">
                        <?php
                        }
                        ?>
                    </div>
                    <div class="card-footer"><b>Atualização:</b>
                        <?php
                        echo $hora_temperatura;
                        // verifica se o utilizador tem permissão para ver o histórico 
                        if ($_SESSION['tipo_user'] == "admin") {
                        ?>
                            - <a href="historico.php?nome=<?php echo $nome_temperatura ?>">Histórico</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Humidade -->
            <div class="col-sm-4">
                <div class="card text-center card-margin">
                    <div class="card-header sensorHum"><strong>
                            <?php echo $nome_humidade ?>:
                            <?php echo $valor_humidade ?>%
                        </strong></div>
                    <div class="card-body">
                        <?php
                        // tendo em consideração que humidade abaixo de 50% é ruim
                        if ($valor_humidade > 50) {
                        ?>
                            <img class="card-image" src="imagens/humidity-high.png" alt="">
                        <?php
                        } else {
                        ?>
                            <img class="card-image" src="imagens/humidity-low.png" alt="">
                        <?php
                        }
                        ?>
                    </div>
                    <div class="card-footer"><b>Atualização:</b>
                        <?php
                        echo $hora_humidade;
                        // verifica se o utilizador tem permissão para ver o histórico
                        if ($_SESSION['tipo_user'] == "admin") {
                        ?>
                            - <a href="historico.php?nome=<?php echo $nome_humidade ?>">Histórico</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Luz -->
            <div class="col-sm-4">
                <div class="card text-center card-margin">
                    <div class="card-header sensorHum"><strong>
                            <?php echo $nome_luz ?>:
                            <?php ($valor_luz==1)? ' Dia' : ' Noite' ?>
                        </strong></div>
                    <div class="card-body">
                        <?php
                        
                        if ($valor_luz == 1) {
                        ?>
                            <img class="card-image" src="imagens/sol.png" alt="">
                        <?php
                        } else {
                        ?>
                            <img class="card-image" src="imagens/lua.png" alt="">
                        <?php
                        }
                        ?>
                    </div>
                    <div class="card-footer"><b>Atualização:</b>
                        <?php
                        echo $hora_luz;
                        // verifica se o utilizador tem permissão para ver o histórico
                        if ($_SESSION['tipo_user'] == "admin") {
                        ?>
                            - <a href="historico.php?nome=<?php echo $nome_luz ?>">Histórico</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Ventilador -->
            <div class="col-sm-4">
                <div class="card text-center card-margin">
                    <div class="card-header atuador"><strong>
                            <?php echo $nome_vent ?>:
                            <?php echo ($valor_vent == 1) ? 'Ativo' : 'Desligado' ?>
                        </strong></div>
                    <div class="card-body">
                        <?php
                        // os leds só podem ter 2 valores, ativos(1) ou desligados(0)
                        if ($valor_vent == 1) {
                        ?>
                            <img class="card-image" src="imagens/ventilador_on.gif" alt="">
                        <?php
                        } else {
                        ?>
                            <img class="card-image" src="imagens/ventilador_off.png" alt="">
                        <?php
                        }
                        ?>
                    </div>
                    <div class="card-footer"><b>Atualização:</b>
                        <?php
                        echo $hora_vent;
                        // verifica se o utilizador tem permissão para ver o histórico
                        if ($_SESSION['tipo_user'] == "admin") {
                        ?>
                            - <a href="historico.php?nome=<?php echo $nome_vent ?>">Histórico</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Humidificador -->
            <div class="col-sm-4">
                <div class="card text-center card-margin">
                    <div class="card-header atuador"><strong>
                            <?php echo $nome_humidificador ?>:
                            <?php echo ($valor_humidificador == 1) ? 'Ativo' : 'Desligado' ?>
                        </strong></div>
                    <div class="card-body">
                        <?php
                        // só podem ter 2 valores, ativos(1) ou desligados(0)
                        if ($valor_humidificador == 1) {
                        ?>
                            <img class="card-image" src="imagens/humidifier_on.png" alt="">
                        <?php
                        } else {
                        ?>
                            <img class="card-image" src="imagens/humidifier_off.png" alt="">
                        <?php
                        }
                        ?>
                    </div>
                    <div class="card-footer"><b>Atualização:</b>
                        <?php
                        echo $hora_humidificador;
                        // verifica se o utilizador tem permissão para ver o histórico
                        if ($_SESSION['tipo_user'] == "admin") {
                        ?>
                            - <a href="historico.php?nome=<?php echo $nome_humidificador ?>">Histórico</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Led -->
            <div class="col-sm-4">
                <div class="card text-center ">
                    <div class="card-header atuador"><strong>
                            <?php echo $nome_led ?>:
                            <?php echo ($valor_led == 1) ? 'Ativo' : 'Desligado' ?>
                        </strong></div>
                    <div class="card-body">
                        <?php
                        // os leds só podem ter 2 valores, ativos(1) ou desligados(0)
                        if ($valor_led == 1) {
                        ?>
                            <img class="card-image" src="imagens/light-on.png" alt="">
                        <?php
                        } else {
                        ?>
                            <img class="card-image" src="imagens/light-off.png" alt="">
                        <?php
                        }
                        ?>
                    </div>
                    <div class="card-footer"><b>Atualização:</b>
                        <?php
                        echo $hora_led;
                        // verifica se o utilizador tem permissão para ver o histórico
                        if ($_SESSION['tipo_user'] == "admin") {
                        ?>
                            - <a href="historico.php?nome=<?php echo $nome_led ?>">Histórico</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Aquecedor -->
            <div class="col-sm-4">
                <div class="card text-center card-margin">
                    <div class="card-header atuador"><strong>
                            <?php echo $nome_aquecedor ?>:
                            <?php echo ($valor_aquecedor == 1) ? 'Ativo' : 'Desligado' ?>
                        </strong></div>
                    <div class="card-body">
                        <?php
                        // os leds só podem ter 2 valores, ativos(1) ou desligados(0)
                        if ($valor_aquecedor == 1) {
                        ?>
                            <img class="card-image" src="imagens/heater_on.png" alt="">
                        <?php
                        } else {
                        ?>
                            <img class="card-image" src="imagens/heater_off.png" alt="">
                        <?php
                        }
                        ?>
                    </div>
                    <div class="card-footer"><b>Atualização:</b>
                        <?php
                        echo $hora_aquecedor;
                        // verifica se o utilizador tem permissão para ver o histórico
                        if ($_SESSION['tipo_user'] == "admin") {
                        ?>
                            - <a href="historico.php?nome=<?php echo $nome_aquecedor ?>">Histórico</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Led Arduino -->
            <div class="col-sm-4">
                <div class="card text-center ">
                    <div class="card-header atuador"><strong>
                            <?php echo $nome_led_arduino ?>:
                            <?php echo ($valor_led_arduino == 1) ? 'Ativo' : 'Desligado' ?>
                        </strong></div>
                    <div class="card-body">
                        <?php
                        // os leds só podem ter 2 valores, ativos(1) ou desligados(0)
                        if ($valor_led_arduino == 1) {
                        ?>
                            <img class="card-image" src="imagens/light-on.png" alt="">
                        <?php
                        } else {
                        ?>
                            <img class="card-image" src="imagens/light-off.png" alt="">
                        <?php
                        }
                        ?>
                    </div>
                    <!-- TO DO - só o admin e o moderador podem ligar/desligar o led -->
                    <div class="container">
                        <button class="col-sm-5" style="display: inline-block" id="ledOn">ON</button>
                        <button class="col-sm-5" style="display: inline-block" id="ledOff">OFF</button>
                    </div>
                    <div class="card-footer"><b>Atualização:</b>
                        <?php
                        echo $hora_led_arduino;
                        // verifica se o utilizador tem permissão para ver o histórico
                        if ($_SESSION['tipo_user'] == "admin") {
                        ?>
                            - <a href="historico.php?nome=<?php echo $nome_led_arduino ?>">Histórico</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Buzzer RaspBerry -->
            <div class="col-sm-4">
                <div class="card text-center ">
                    <div class="card-header atuador"><strong>
                            <?php echo $nome_buzzer_rasp ?>:
                            <?php echo ($valor_buzzer_rasp == 1) ? 'Ativo' : 'Desligado' ?>
                        </strong></div>
                    <div class="card-body">
                        <?php
                        // os leds só podem ter 2 valores, ativos(1) ou desligados(0)
                        if ($valor_buzzer_rasp == 1) {
                        ?>
                            <img class="card-image" src="imagens/light-on.png" alt="">
                        <?php
                        } else {
                        ?>
                            <img class="card-image" src="imagens/light-off.png" alt="">
                        <?php
                        }
                        ?>
                    </div>
                    <!-- TO DO - só o admin e o moderador podem ligar/desligar o buzzer -->
                    <div class="container">
                        <button class="col-sm-5" style="display: inline-block" id="buzzerOn">ON</button>
                        <button class="col-sm-5" style="display: inline-block" id="buzzerOff">OFF</button>
                    </div>
                    <div class="card-footer"><b>Atualização:</b>
                        <?php
                        echo $hora_led_arduino;
                        // verifica se o utilizador tem permissão para ver o histórico
                        if ($_SESSION['tipo_user'] == "admin") {
                        ?>
                            - <a href="historico.php?nome=<?php echo $nome_led_arduino ?>">Histórico</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>


            <!-- NADA -->
            <div class="col-sm-4">
                
            </div>

            <!-- Webcam -->
            <div class="col-sm-4" style="margin-top: 3%;">
                <div class="card text-center card-margin">
                    <div class="card-header atuador"><strong>
                            <?php echo "Imagem" ?>
                        </strong></div>
                    <div class="card-body">
                        <?php
                        echo "<img src='api/imagens/webcam.jpg?id=" . time() . "'style='width:100%'>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="container">
        <div class="card">
            <div class="card-header"><strong>Tabela de Sensores</strong></div>
            <div class="card-body">
                <table class="table" id="deviceTable">
                    <thead>
                        <tr>
                            <th scope="col">Tipo de Dispositivo IoT</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Data de Atualização</th>
                            <th scope="col" class="text-center">Estado Alertas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" class="device-nome">
                                <?php echo $nome_temperatura ?>
                            </th>
                            <td class="device-valor">
                                <?php echo $valor_temperatura ?>ºC
                            </td>
                            <td class="device-hora">
                                <?php echo $hora_temperatura ?>
                            </td>

                            <?php
                            // verficar qual o estado/alerta
                            if ($valor_temperatura > 30) {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-danger">Elevada</span></td>
                            <?php
                            } else if ($valor_temperatura < 10) {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-warning">Baixa</span></td>
                            <?php
                            } else {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-success">Normal</span></td>
                            <?php
                            }
                            ?>
                        </tr>

                        <tr>
                            <th scope="row" class="device-nome">
                                <?php echo $nome_humidade ?>
                            </th>
                            <td class="device-valor">
                                <?php echo $valor_humidade ?>%
                            </td>
                            <td class="device-hora">
                                <?php echo $hora_humidade ?>
                            </td>
                            <?php
                            // verficar qual o estado/alerta
                            if ($valor_humidade > 50) {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-success">Normal</span></td>
                            <?php
                            } else {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-danger">Baixa</span></td>
                            <?php
                            }
                            ?>
                        </tr>

                        <tr>
                            <th scope="row" class="device-nome">
                                <?php echo $nome_luz ?>
                            </th>
                            <td class="device-valor">
                                <?php ($valor_luz)? 'Dia' : 'Noite' ?>
                            </td>
                            <td class="device-hora">
                                <?php echo $hora_luz ?>
                            </td>
                            <?php
                            // verficar qual o estado/alerta
                            if ($valor_luz == 1) {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-warning">Dia</span></td>
                            <?php
                            } else {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-dark">Noite</span></td>
                            <?php
                            }
                            ?>
                        </tr>

                        <tr>
                            <th scope="row" class="device-nome">
                                <?php echo $nome_led ?>
                            </th>
                            <td class="device-valor">
                                <?php echo ($valor_led == 1) ? 'Ativo' : 'Desligado' ?>
                            </td>
                            <td class="device-hora">
                                <?php echo $hora_led ?>
                            </td>

                            <?php
                            // verficar qual o estado/alerta
                            if ($valor_led == 1) {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-success">Ativo</span></td>
                            <?php
                            } else {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-secondary">Desligado</span></td>
                            <?php
                            }
                            ?>
                        </tr>

                        <tr>
                            <th scope="row" class="device-nome">
                                <?php echo $nome_humidificador ?>
                            </th>
                            <td class="device-valor">
                                <?php echo ($valor_humidificador == 1) ? 'Ativo' : 'Desligado' ?>
                            </td>
                            <td class="device-hora">
                                <?php echo $hora_humidificador ?>
                            </td>

                            <?php
                            // verficar qual o estado/alerta
                            if ($valor_humidificador == 1) {
                            ?>
                                <td class=" text-center device-estado"><span class="badge text-bg-success">Ativo</span></td>
                            <?php
                            } else {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-secondary">Desligado</span></td>
                            <?php
                            }
                            ?>
                        </tr>


                        <tr>
                            <th scope="row" class="device-nome">
                                <?php echo $nome_vent ?>
                            </th>
                            <td class="device-valor">
                                <?php echo ($valor_vent == 1) ? 'Ativo' : 'Desligado' ?>
                            </td>
                            <td class="device-hora">
                                <?php echo $hora_vent ?>
                            </td>

                            <?php
                            // verficar qual o estado/alerta
                            if ($valor_vent == 1) {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-success">Ativo</span></td>
                            <?php
                            } else {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-secondary">Desligado</span></td>
                            <?php
                            }
                            ?>
                        </tr>


                        <tr>
                            <th scope="row" class="device-nome">
                                <?php echo $nome_aquecedor ?>
                            </th>
                            <td class="device-valor">
                                <?php echo ($valor_aquecedor == 1) ? 'Ativo' : 'Desligado' ?>
                            </td>
                            <td class="device-hora">
                                <?php echo $hora_aquecedor ?>
                            </td>

                            <?php
                            // verficar qual o estado/alerta
                            if ($valor_aquecedor == 1) {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-success">Ativo</span></td>
                            <?php
                            } else {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-secondary">Desligado</span></td>
                            <?php
                            }
                            ?>
                        </tr>
                    
                            
                        <tr>
                            <th scope="row" class="device-nome">
                                <?php echo $nome_led_arduino ?>
                            </th>
                            <td class="device-valor">
                                <?php echo ($valor_led_arduino == 1) ? 'Ativo' : 'Desligado' ?>
                            </td>
                            <td class="device-hora">
                                <?php echo $hora_led_arduino ?>
                            </td>

                            <?php
                            // verficar qual o estado/alerta
                            if ($valor_led_arduino == 1) {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-success">Ativo</span></td>
                            <?php
                            } else {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-secondary">Desligado</span></td>
                            <?php
                            }
                            ?>
                        </tr>

                        <tr>
                            <th scope="row" class="device-nome">
                                <?php echo $nome_buzzer_rasp ?>
                            </th>
                            <td class="device-valor">
                                <?php echo ($valor_buzzer_rasp == 1) ? 'Ativo' : 'Desligado' ?>
                            </td>
                            <td class="device-hora">
                                <?php echo $hora_buzzer_rasp ?>
                            </td>

                            <?php
                            // verficar qual o estado/alerta
                            if ($valor_buzzer_rasp == 1) {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-success">Ativo</span></td>
                            <?php
                            } else {
                            ?>
                                <td class="text-center device-estado"><span class="badge text-bg-secondary">Desligado</span></td>
                            <?php
                            }
                            ?>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>


    <br>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>