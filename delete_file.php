<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file'])) {
    // Diretório onde os arquivos estão armazenados
    $directory = __DIR__ . '/PUBLIC_HTML/';
    $fileName = basename($_POST['file']); // Protege contra path traversal
    $filePath = $directory . $fileName;

    // Verifica se o arquivo existe antes de tentar excluir
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo "Arquivo '$fileName' excluído com sucesso.";
        } else {
            echo "Erro ao tentar excluir o arquivo '$fileName'.";
        }
    } else {
        echo "Arquivo '$fileName' não encontrado.";
    }
} else {
    echo "Requisição inválida.";
}
?>
