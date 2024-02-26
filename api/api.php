<?php

header('Content-Type: text/html; charset=utf-8');

//echo $_SERVER['REQUEST_METHOD'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['nome']) && isset($_POST['valor']) && isset($_POST['hora'])) {

        if (file_exists("files/" . $_POST['nome'])) {

            if ((strtolower($_POST['nome']) == 'led' || strtolower($_POST['nome']) == 'humidificador' || strtolower($_POST['nome']) == 'aquecedor' || strtolower($_POST['nome']) == 'ventilador') && ($_POST['valor'] < 0 || $_POST['valor'] > 1)) {
                echo "Parâmetro valor recebido não é válido";
                http_response_code(400);
            } else {

                if (strtolower($_POST['nome']) == 'humidade' && ($_POST['valor'] < 0 || $_POST['valor'] > 100)) {
                    echo "Parâmetro 'valor' recebido não é válido";
                    http_response_code(400);
                } else {

                    file_put_contents("files/" . $_POST['nome'] . "/valor.txt", $_POST['valor']);  //valor
                    file_put_contents("files/" . $_POST['nome'] . "/hora.txt", $_POST['hora']);  //hora

                    file_put_contents("files/" . $_POST['nome'] . "/log.txt", $_POST['hora'] . ";" . $_POST['valor'] . PHP_EOL, FILE_APPEND);  //log

                    print_r($_POST);
                }
            }
        } else {
            echo "Parâmetro 'nome' recebido não é válido";
            http_response_code(400);
        }
    } else {
        echo "Parâmetros recebidos não são válidos";
        http_response_code(400);
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['nome'])) {

            if (file_exists("files/" . $_GET['nome'] . "/valor.txt")) {
                echo file_get_contents("files/" . $_GET['nome'] . "/valor.txt");
            } else {
                echo "Parâmetro 'nome' recebido não é válido";
                http_response_code(400);
            }
        } else {
            echo "Parâmetros recebidos não são válidos";
            http_response_code(400);
        }
    } else {
        echo "Metodo não permitido";
        http_response_code(403);
    }
}
