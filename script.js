
document.getElementById('code-editor-id').addEventListener('input',function(){
    document.getElementById('marq-salvar').style.display = 'block';
    
    //  Arquivo alterado reload recarga quente
    var fileName = "";

    if(document.getElementById('action-edit').value != "" 
        && document.getElementById('action-edit').value != null 
        && document.getElementById('action-edit').value != undefined) {
        fileName = document.getElementById('action-edit').value;
    } 

    if(fileName.includes(".php") || fileName.includes(".html")) {
        hotReload();
    }
});

function createFile() {
    const name = prompt('Digite o nome do novo arquivo:');
    if (name) {
        fetch('create_folder_and_file.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'create-file',
                name: name
            })
        }).then(() => location.reload());
    }
}

function loadFile(fileName) {
    
    if(fileName != "" && fileName != null && fileName != undefined){
        document.getElementById('marq-file-selected').innerHTML = fileName;
        document.getElementById('action-edit').value = fileName;

        // Botão salvar volta a esconder, só mostra quando for editado o arquivo
        document.getElementById('marq-salvar').style.display = 'none';



        // Só aparece o hot reload para paginas .php/.html
        if(fileName.includes(".php") || fileName.includes(".html")) {
            document.getElementById('marq-hot-reload').style.display = "block";
            document.getElementById('marq-pre-visualizar').style.display = "block";

            // Limpa o iframe caso o mesmo tenha conteudo antigo
            document.getElementById('webview').value = "";
            document.getElementById('webview').style.display = "block";
            document.getElementById('webview').style.background = "#fff";

            // Muda o posicionamento do botão quando for de .php /.html
            document.getElementById('marq-salvar').style.right = "220px";
    
        } else {
            document.getElementById('marq-hot-reload').style.display = "none";
            document.getElementById('marq-pre-visualizar').style.display = "none";
            document.getElementById('webview').style.background = "transparent";
            
            // Limpa o iframe caso o mesmo tenha conteudo
            document.getElementById('webview').value = "";
            document.getElementById('webview').style.display = "none";

            // Muda o posicionamento do botão quando for diferente de .php /.html
            document.getElementById('marq-salvar').style.right = "30px";
        }
    }

    // Faz uma requisição para obter o conteúdo do arquivo
    fetch('open_file.php?file=' + encodeURIComponent(fileName))
        .then(response => response.text())
        .then(data => {
            document.getElementById('code-editor-id').value = data;
        })
        .catch(error => {
            document.getElementById('action-edit').value = "";
            console.error('Erro ao carregar o arquivo:', error);
        });
}

function preVisualizar(){
    // TODO:Ajustar para deixar dinamico
    let url = "/PUBLIC_HTML/index.html";
    window.open(url, '_blank');
}

function createFolder() {
    const name = prompt('Digite o nome da nova pasta:');
    if (name) {
        fetch('create_folder_and_file.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'create-folder',
                name: name
            })
        }).then(() => location.reload());
    }
}

function salvarNovoArquivoComCodigo(){
    // Captura o conteúdo do textarea
    const content = document.getElementById('code-editor-id').value;
    var fileName = "";
    
    // Se for uma edição não precisa perguntar o nome do arquivo
    if(document.getElementById('action-edit').value != "" 
    && document.getElementById('action-edit').value != null 
    && document.getElementById('action-edit').value != undefined) {
        fileName = document.getElementById('action-edit').value;
    } else {
        // Solicita o nome do arquivo ao usuário
        fileName = prompt('Digite o nome do arquivo (com extensão):');
    } 

    // Verifica se o usuário inseriu um nome
    if (fileName) {
        // Envia o conteúdo e o nome do arquivo para o servidor usando fetch
        fetch('save_file.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                fileName: fileName,
                content: content,
                action : 'create-file-code',
            })
        })
        .then(response => response.text())
        .then(data => {
             new Noty({
                type: 'info',
                layout: 'topRight',
                text: data,
                timeout: 3000
            }).show();

            if(document.getElementById('action-edit').value != "" 
            && document.getElementById('action-edit').value != null 
            && document.getElementById('action-edit').value != undefined) {
                // Botão salvar volta a esconder apos salvar
                document.getElementById('marq-salvar').style.display = 'none';
            } else {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    } else {
         new Noty({
            type: 'info',
            layout: 'topRight',
            text: 'Nome do arquivo não pode ser vazio.',
            timeout: 3000
        }).show();
    }
}

function hotReload(){
 // Captura o conteúdo do textarea
 var codeContent = document.getElementById('code-editor-id').value;

 // Envia o conteúdo via POST para o PHP
 fetch('webview.php', {
     method: 'POST',
     headers: {
         'Content-Type': 'application/x-www-form-urlencoded'
     },
     body: 'code=' + encodeURIComponent(codeContent)
 })
 .then(response => response.text())
 .then(htmlContent => {
     // Atualiza a webview com o conteúdo retornado
     var webview = document.getElementById('webview');
     webview.srcdoc = htmlContent;
 });
}

function expandScreen(){
    if(document.getElementById('isExpand').value != "" 
        && document.getElementById('isExpand').value != null 
        && document.getElementById('isExpand').value != undefined) {
            // fechar o expand
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }    
            
            // seta vazio para o campo para poder funcionar certinho os eventos
            document.getElementById('isExpand').value = "";

    } else {
        // Verifica se o navegador suporta a função de tela cheia
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) { // Para o Firefox
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) { // Para o Chrome, Safari e Opera
            document.documentElement.webkitRequestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) { // Para o IE/Edge
            document.documentElement.msRequestFullscreen();
        }

        // seta expand para o campo para poder funcionar certinho os eventos
        document.getElementById('isExpand').value = "expand";
    }
}

// TODO:
document.getElementById('marq-btn-chat-ia').addEventListener('click', function() {
     new Noty({
        type: 'info',
        layout: 'topRight',
        text: 'NOTE: Ao clicar aqui deverá abrir um ambiente para solicitar ajudar a AI Google Gemini ** Em desenvolvimento',
        timeout: 3000
    }).show();
});

function removeFile(fileName) {
    if (confirm("Tem certeza que deseja excluir o arquivo " + fileName + "?")) {
        // Faz a requisição AJAX para o PHP para excluir o arquivo
        fetch('delete_file.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'file=' + encodeURIComponent(fileName)
        })
        .then(response => response.text())
        .then(result => {
            
             new Noty({
                type: 'info',
                layout: 'topRight',
                text: result,
                timeout: 3000
            }).show();
            location.reload(); // Atualiza a página para refletir as mudanças
        })
        .catch(error => {
            console.error('Erro:', error);
             new Noty({
                type: 'info',
                layout: 'topRight',
                text: 'Ocorreu um erro ao tentar excluir o arquivo.',
                timeout: 3000
            }).show();
        });
    }
}

function loadYouTube() {
    document.getElementById('marq-area-webview-youtube').style.display = "block";

    var videoId = prompt('Informe o videoId do youtube:');

    if(videoId == '' || videoId == null || videoId == undefined) {
        new Noty({
            type: 'info',
            layout: 'topRight',
            text: 'Por favor, insira um videoId válido do YouTube.\n\nEx:\n Tn7OlZa8jF0?si=Och41vixnSAMbvAK  \n h7ZjHacq9hU?si=mIpmKcfCfafNiJkW  \n  lAT49FM0bbU?si=BttVgjkIYMR68kk3',
            timeout: 3000
        }).show();
    } else {
        var url = 'https://www.youtube.com/embed/'+videoId;
    
        // Validar se é um URL do YouTube
        if (url.includes("youtube.com") || url.includes("youtu.be")) {
            document.getElementById('webview-youtube').src = url;
        } else {
            new Noty({
                type: 'info',
                layout: 'topRight',
                text: 'Por favor, insira uma URL válida do YouTube.',
                timeout: 3000
            }).show();
        }
    }
}