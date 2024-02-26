<?php
session_start();


if (isset($_POST['username']) && isset($_POST['password'])) {


    // pegar todas as credenciais do ficheiro
    $credenciais = file("api/files/users/credenciais.txt");

    // percorrer o for por cada linha
    foreach ($credenciais as $credencial) {
        // separar os dados do user
        $user = explode(";", $credencial);
        // retirar o espaço que existia no final da password
        $user[2] = rtrim($user[2]);


        /*
        $user {
            $user[0] =>
                string(4) "user"    -> tipo de utilizador
            $user[1] =>
                string(4) "aaaa"    -> username
            $user[2] =>
                string(60) "$2y$10$pKGa3EU377uT49HdbPyDzuJBe6LYsYvIsDATFKixsGrzSjmGBknzW"     -> password_hash
        }
        */

        // se o username enviado por post for igual a username guardado no ficheiro E a password for a mesma
        if ($_POST['username'] == $user[1] && password_verify($_POST['password'], $user[2])) {

            // salva o username e o tipo de user em uma variável predefinida do php
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['tipo_user'] = $user[0];

            // mostra que o login foi efetuado
            $dados = true;

            //envia o user para a dashboard
            header("refresh:2;url=dashboard.php");
            //sai do ciclo
            break;
        } else {
            // informa ao user que os dados estão incorretos, por questão de segurança não diz se é o username ou a password que esta incorreta
            $dados = false;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estufa Inteligente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=<?php echo time() ?>">
</head>

<body style="height: 100%">
    <div class="bg-image"></div>
    <div class="bg-login">

        <div class="vh-100">
            <div class="container py-5 h-100">
                <div class="row justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                        <div class="card shadow-2-strong" style="border-radius: 1rem; box-shadow: 0px 0px 10px 10px rgba(0,0,0,.5);">
                            <div class="card-body p-5 text-center">
                                <form method="post">

                                    <h3 class="mb-5">Login</h3>

                                    <div class="form-outline mb-4">
                                        <input type="text" name="username" class="form-control form-control-lg" required placeholder="Username">

                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="password" name="password" class="form-control form-control-lg" required placeholder="Password">
                                    </div>

                                    <hr class="my-6">

                                    <button class="btn btn-primary btn-lg btn-block buttonSubmit" type="submit">Login</button>
                                    <br>
                                    <br>
                                    <?php
                                    // verifica se foi feito o login
                                    if (isset($dados)) {

                                        // se os dados inseridos forem corretos
                                        if ($dados == true) {
                                    ?>
                                            <div class="alert alert-success" role="alert">
                                                Login Efetuado
                                            </div>
                                        <?php
                                            // senão
                                        } else {
                                        ?>
                                            <div class="alert alert-warning" role="alert">
                                                Dados Incorretos
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>