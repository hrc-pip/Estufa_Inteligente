<?php
session_start();
//Acesso interdito a todos os que não têm sessão iniciada
if (!isset($_SESSION['username'])) {
    header("refresh:5;url=index.php");
    die("Acesso interdito.");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Gráfico da Estufa Inteligente</title>
    <!-- Carrega o CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="30">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #ebebeb;
        }

        .navbar {
            margin-bottom: 0;
            /* Adiciona margem inferior zero para que fique no topo da página */
        }

        .chart-container {
            width: 600px;
            height: 400px;
            margin: 0 auto;
        }

        canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
    <meta http-equiv="refresh" content="30">
    <!-- Coloca um ícone como imagem no separador do site -->
    <link rel="icon" type="image/png" href="favicon.png">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary color">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Painel de Controlo - Estufa Inteligente</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard.php">Home</a>
                    </li>
                    </li>
                </ul>
                <a href="logout.php" class="btn btn-light border-dark">Logout</a>
            </div>
        </div>
    </nav>
    <br>
    <div class="chart-container">
        <canvas id="productionChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>