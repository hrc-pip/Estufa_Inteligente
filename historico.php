<?php

session_start();


if (!isset($_SESSION['username']) || $_SESSION['tipo_user'] != "admin") {
    header("refresh:5;url=index.php");
    die("Acesso restrito. ");
}



if (isset($_GET['nome'])) {
    $nome_sensor = $_GET['nome'];

    if (file_exists("api/files/" . $nome_sensor)) {

        $log = file("api/files/$nome_sensor/log.txt");
    } else {

        header("refresh:5;url=dashboard.php");
        http_response_code(400);
        die("Parâmetros recebidos não são válidos");
    }
} else {
    header("refresh:5;url=dashboard.php");
    http_response_code(400);
    die("Parâmetros recebidos não são válidos");
}
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="refresh" content="5">


    <title>Estufa Inteligente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=<?php echo time() ?>">
</head>

<body class="bg-imageDashboard">


    <nav class="navbar navbar-light navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Estufa Inteligente</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Histórico</a>
                    </li>
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
                <h1 class="card-title"> <b>Histórico - Estufa Inteligente</b> </h1>
                <p>Histórico do sensor de
                    <?php echo $nome_sensor ?>
                </p>
            </div>
        </div>
    </div>

    <br>


    <div class="container">
        <div class="card">
            <div class="card-header"><strong>Tabela de Registo de Dados</strong></div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Data de registo</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <?php

                    // por cada linha do ficheiro log.txt
                    foreach ($log as $log) {
                        // separa os campos, retirando pelo ;
                        $campos = explode(";", $log);
                    ?>

                        <tbody>
                            <tr>
                                <th scope="row">
                                    <?php
                                    // Data do registo de alteração
                                    echo $campos[0]
                                    ?>
                                </th>
                                <td>
                                    <?php
                                    // valor salvo
                                    echo $campos[1]
                                    ?>
                                </td>
                            </tr>
                        </tbody>

                    <?php
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>


    <br>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>