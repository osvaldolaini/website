var UploadImage = function () {
    /*Efeito hover no drag drop*/
    let dragDropEvents = function(){
        $(document).on('dragenter', '.area-upload', function () {
            $('.area-upload .label-upload').addClass('highlight')
        })
        $(document).on('dragleave drop', '.area-upload', function () {
            $('.area-upload .label-upload').removeClass('highlight')
        })
    }
    /*Validar arquivos*/
    function validarArquivo(file){
        // Tipos permitidos
        var mime_types = ['image/jpeg','image/png','image/jpeg','image/webp'];
        // Validar os tipos
        if(mime_types.indexOf(file.type) == -1) {
            return {"error" : "O arquivo " + file.name + " não permitido"};
        }
        // Apenas 2MB é permitido
        if(file.size > 2*1024*1024) {
            return {"error" : file.name + " ultrapassou limite de 2MB"};
        }
        // Se der tudo certo
        return {"success": "Enviando: " + file.name};
    }
    /*Testando a imagem para upload*/
    let dropImage = function(){
        $(document).on('change', '.upload-file', function () {
            var files = this.files;
            for(var i = 0; i < files.length; i++){
                var info = validarArquivo(files[i]);
                //console.log(info.error)
                //Criar barra
                var barra = document.createElement("div");
                var fill = document.createElement("div");
                var text = document.createElement("div");
                barra.appendChild(fill);
                barra.appendChild(text);

                barra.classList.add("barra");
                fill.classList.add("fill");
                text.classList.add("text");

                if(info.error == undefined){
                    text.innerHTML = info.success;
                    enviarArquivo(i, barra); //Enviar
                }else{
                    text.innerHTML = info.error;
                    barra.classList.add("error");
                }
                //Adicionar barra
                document.querySelector('.lista-uploads').appendChild(barra);
            };
        });
    }
    /*Realizando o upload da imagem via ajax */
        function enviarArquivo(indice, barra){
            var data = new FormData();
            var request = new XMLHttpRequest();
            //Adicionar arquivo
            data.append('file', document.querySelector('.upload-file').files[indice]);
            // AJAX request finished
            request.addEventListener('load', function(e) {
                // Resposta
                if(request.response.status == "success"){
                    barra.querySelector(".text").innerHTML = "<div><span>"+request.response.name+"</span>"+
                    '<a style="cursor:pointer;color: #fff;" class="btn btn-secondary py-0 ml-1 btn-featured stars">Destaque <i class="fas fa-star"></i></a>'+
                    '<input type="hidden" name="featured[]" value="0">'+
                    '<a style="cursor:pointer;color: #fff;" data-path="'+request.response.path+'" data-image="'+request.response.name+'" class="btn btn-info py-0 ml-1 text-white showImage">Visualizar <i class="fas fa-image" ></i></a>'+
                    '<a style="cursor:pointer;color: #fff;" class="btn btn-danger py-0 ml-1 btn-delete-image text-white">Remover <i class="fas fa-trash-alt" ></i></a>'+
                    '</div><input type="hidden" name="images[]" value="'+request.response.name+'">';
                    barra.classList.add("complete");
                }else{
                    barra.querySelector(".text").innerHTML = "Erro ao enviar: " + request.response.name;
                    barra.classList.add("error");
                }
            });

            // Calcular e mostrar o progresso
            request.upload.addEventListener('progress', function(e) {
                var percent_complete = (e.loaded / e.total)*100;
                barra.querySelector(".fill").style.minWidth = percent_complete + "%";
            });

            //Resposta em JSON
            request.responseType = 'json';
            // Caminho
            request.open('post', APP_URL + "/uploads");
            request.setRequestHeader('x-csrf-token', CSRF_TOKEN);
            request.send(data);
        }

    /*Modal para visualizar a imagem*/
    let viewImages = function(){
        $(document).on('click', '.showImage', function () {
            let path = $(this).data("path");
            let image = $(this).data("image");
            $('body').append('<div class="modal fade" id="imagesModel">'+
                '<div class="modal-dialog">'+
                  '<div class="modal-content">'+
                    '<div class="modal-header"><h5>'+image+'</h5><button type="button" class="close removeModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'+
                    /*Modal body */
                    '<div class="modal-body"></div>'+
                  '</div>'+
                '</div>'+
              '</div>');
            $('#imagesModel .modal-body').append('<img src="'+path+'/'+image+'" class="w-50 mx-auto d-block">');
            $('#imagesModel').modal({shown:true});
        });
        /*Remover o modal*/
        $(document).on('click','.removeModal', function(){
            $('#imagesModel').modal({hide:true});
            if($('#imagesModel').modal({hide:true})){
                $('#imagesModel img').remove();
            }
        });
    }
    /*Imagem em destaque */
    let featuredImage = function(){
        $(document).on('click','.btn-featured', function(){
            $('[name="featured[]"]').val('0');
            $(this).parent().children().val('1');
            $('.stars').removeClass('btn-warning');
            $('.stars').addClass('btn-secondary');
            $(this).removeClass('btn-secondary');
            $(this).addClass('btn-warning');
        });
    }
    /*Excluir imagem */
    let deleteImage = function(){
        $(document).on('click','.btn-delete-image', function(){
            $(this).parent().parent().parent().remove();
        });
    }

    return{
        init: function(){
            dragDropEvents()
            dropImage()
            viewImages()
            featuredImage()
            deleteImage()
        }
    }
}()
jQuery(document).ready(function(){
    UploadImage.init()
})
