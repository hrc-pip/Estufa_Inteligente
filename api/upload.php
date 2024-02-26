<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $allowedExtensions = array('jpg', 'png');
        $maxFileSize = 1000 * 1024; // 1000kB

        $fileExtension = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        $fileSize = $_FILES['imagem']['size'];

       // if (in_array($fileExtension, $allowedExtensions) && $fileSize <= $maxFileSize) {
            // Move os ficheiros para a diretoria api/imagens/
            move_uploaded_file($_FILES['imagem']['tmp_name'], "./imagens/webcam.$fileExtension");
        //} else {
        //    echo 'Imagem inválida. A imagem deve ter um tamanho máximo de 1000kB e estar nos formatos .jpg ou .png.';
        //    http_response_code(403);
        //}
    } else {
        echo 'Imagem não encontrada';
        http_response_code(403);
    }
} else {
    echo 'Método não permitido';
    http_response_code(403);
}
