<?php

// Verifica se um arquivo foi solicitado para exibição
if (isset($_GET['file'])) {
    // Diretório onde os arquivos estão armazenados
    $directory = realpath(__DIR__.'/PUBLIC_HTML/');

    // Constrói o caminho absoluto do arquivo solicitado
    $requestedFile = basename($_GET['file']); // Protege contra path traversal
    $filePath = realpath($directory . '/' . $requestedFile);

    // Verifica se o arquivo existe e está dentro do diretório permitido
    if ($filePath && strpos($filePath, $directory) === 0 && file_exists($filePath)) {
        echo file_get_contents($filePath);
        exit;
    } else {
        echo "Arquivo não encontrado ou acesso não permitido.";
        exit;
    }
}
