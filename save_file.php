<?php
// Obtém os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['fileName']) && isset($data['content']) && !empty($data['content'])) {
    // Sanitiza o nome do arquivo
    $fileName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $data['fileName']);

    // Define o caminho completo para salvar o arquivo
    $filePath = __DIR__ . '/PUBLIC_HTML/' . $fileName;

    // Tenta salvar o arquivo
    if (file_put_contents($filePath, $data['content'])) {
        echo "Arquivo salvo com sucesso.";
    } else {
        echo "Erro ao salvar o arquivo.";
    }

} else if(isset($data['fileName']) && isset($data['content']) && empty($data['content'])) {
    // Sanitiza o nome do arquivo
    $fileName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $data['fileName']);

    // Define o caminho completo para salvar o arquivo
    $filePath = __DIR__ . '/PUBLIC_HTML/' . $fileName;

    // Tenta salvar o arquivo
    if (file_put_contents($filePath, ' ')) {
        echo "Arquivo salvo com sucesso.";
    } else {
        echo "Erro ao salvar o arquivo.";
    }
} else {
    echo "Dados incompletos.";
}
?>
