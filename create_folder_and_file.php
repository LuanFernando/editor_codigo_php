<?php

    // Lógica PHP para criar pastas e arquivos
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            $name = $_POST['name'];
            $path = __DIR__ . '/PUBLIC_HTML/' . $name;
  
            if ($action === 'create-folder') {
                mkdir($path);
            } elseif ($action === 'create-file') {
                file_put_contents($path, '');
            }
        }
        exit;
    }
  