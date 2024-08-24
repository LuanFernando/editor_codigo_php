<?php

    // Lógica PHP para listar arquivos e pastas
    $files = scandir(__DIR__ . '/PUBLIC_HTML');
    
    function hasValidExtension($filename) {
      // Obtem a extensão do arquivo
      $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
  
      // Define as extensões arquivos
      $validExtensions = ['js', 'css', 'php', 'txt', 'env', 'xml', 'pdf', 'html', 'xls', 'zip', 'img', 'png', 'jpg'];
  
      // Verifica se a extensão está na lista de extensões válidas
      return in_array($extension, $validExtensions);
  }

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MarQ code editor :: web</title>
    <link rel="stylesheet" href="style_index.css" />

    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css">

  </head>
  <body>
    <!-- inicio menu -->
    <div class="marq-menu-editor">
      <label class="marq-label-logo poppins-regular"
        ><span class="marq-span-marq poppins-semibold">MarQ</span>
        <span class="marq-span-code poppins-semibold">Code</span>
        <span class="marq-span-editor poppins-semibold">Editor</span></label
      >

      <div>
        <button type="button" class="marq-btn-expanda" id="marq-btn-expanda" onClick="expandScreen()"><i class="fa fa-arrows-alt" aria-hidden="true"></i></button>
        <input type="hidden" name="isExpand" id="isExpand" value="">

        <button type="button" onclick="loadYouTube()" class="marq-btn-youtube" id="marq-btn-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></button>

        <button type="button" class="marq-btn-chat-ia" id="marq-btn-chat-ia"><i class="fa fa-comments" aria-hidden="true"></i></button>
      </div>

    </div>
    <!-- fim menu -->

    <!-- inicio área editor de código -->
    <div class="marq-area-editor">
      <!-- diretorios/files -->
      <div class="marq-diretorio-file">
        <!-- ações -->
        <div class="marq-acoes-diretorio">
          <button type="button" class="marq-btn-nova-pasta" onclick="createFolder()">
            <i class="fa fa-folder" aria-hidden="true"></i> nova pasta
          </button>
          <button type="button" class="marq-btn-novo-arquivo" onClick="createFile()">
            <i class="fa fa-plus" aria-hidden="true"></i>  novo arquivo
          </button>
        </div>

        <!-- lista diretorio -->
        <div class="marq-lista-diretorios">
          <ul class="poppins-regular">

            <li><a href="#"> <strong class="marq-hash"><i class="fa fa-folder" aria-hidden="true"></i> </strong> PUBLIC_HTML </a></li>
              
            <!-- Percorre listandos pastas e arquivos -->
            <?php foreach ($files as $file): ?>
              <?php if ($file !== '.' && $file !== '..'): ?>
              
                <!-- Pasta -->
                <?php if(!hasValidExtension(htmlspecialchars($file))): ?>
                  <li><a href=""> <strong class="marq-hash">#</strong> <?php echo htmlspecialchars($file); ?> </a></li>
                <?php endif; ?>

                <!-- Arquivos -->
                <?php if(hasValidExtension(htmlspecialchars($file))): ?>
                  <li>
                    <div class="marq-action-files"> 
                      <strong class="marq-hash-arquivo"> <i class="fa fa-file" id="fa-fa-file" aria-hidden="true"></i> </strong> <?php echo htmlspecialchars($file); ?> 
                      <div class="marq-buttons">
                        <button type="button" id="marq-btn-open" onclick="loadFile('<?php echo htmlspecialchars($file); ?>')" ><i class="fa fa-pencil-square-o" id="fa-fa-pencil-square-o" aria-hidden="true"></i></button>
                        <button type="button" id="marq-btn-remove" onclick="removeFile('<?php echo htmlspecialchars($file); ?>')" ><i class="fa fa-trash" id="fa-fa-trash" aria-hidden="true"></i></button>
                      </div>
                    </div>
                </li>
                <?php endif; ?>

              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
              
          <!-- inicio webview youtube -->
          <div class='marq-area-webview-youtube' id="marq-area-webview-youtube">
            <iframe id="webview-youtube" src="about:blank"></iframe>
          </div>
          <!-- final webview youtube -->

        </div>
      </div>

      <!-- code -->
      <div class="marq-code-editor">
        <div class="marq-editor-header poppins-regular">
          <div class="marq-file-name">* <label id='marq-file-selected'></label> *</div>
          <input type="hidden" name="action-edit" id="action-edit" value="">
        </div>

        <div class="marq-editor-2-partes">
          <textarea
            class="code-editor" 
            id="code-editor-id" 
            spellcheck="false" 
            placeholder="Digite seu código aqui..."
          ></textarea>
  
          <!-- carregamento a quente -->
          <iframe id="webview" src="about:blank"></iframe>
        </div>

      </div>
    </div>
    <!-- fim área editor de código -->

    <!-- inicio botão de preview -->
    <button type="button" class="marq-salvar" id="marq-salvar" style="display:none;" onClick="salvarNovoArquivoComCodigo()"><i class="fa fa-floppy-o" aria-hidden="true"></i> salvar</button>

    <button type="button" class="marq-hot-reload" id="marq-hot-reload" style="display:none;" onClick="hotReload()"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i> ver recarga quente</button>
    <button type="button" class="marq-pre-visualizar" id="marq-pre-visualizar" style="display:none;" onClick="preVisualizar()"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i> pré visualizar tela cheia</button>
    <!-- fim botão de preview -->

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>
    <script src="script.js?v=1.1"></script>

  </body>
</html>
