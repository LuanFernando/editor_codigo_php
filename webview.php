<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code'])) {
    // Sanitiza o código para evitar ataques XSS
    $code = htmlspecialchars($_POST['code']);

    // Retorna o código como HTML
    // echo $code;
    echo $_POST['code'];
} else {
    echo "Nenhum código foi enviado.";
}
?>
