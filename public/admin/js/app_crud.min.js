var App_crud = function () {
    /*Controller */
    let controller = function(){
        const pathname = window.location.pathname
        let path = pathname.split("/")
        //Local
        return path[3]
        //Rede
        //return path[1]
    }

    /*Verifica required */
    function info(form) {
        var retorno_erro_validacao = ''
        var erro_validacao = false
        $(form).find('select,input').each(function(){
            if($(this).prop('required') && $(this).prop('disabled')==false){
                if (!$(this).val()){
                    var field = $(this).attr('name');
                    erro_validacao = true;
                    var nome_campo = $(this).attr('data-name');
                    retorno_erro_validacao +='<p class="text-danger"><i class="fas fa-exclamation-triangle"></i> '+ nome_campo + ' é um campo obrigatório</p>';
                    $('[data-name="'+nome_campo+'"]').parent().children().addClass('has-error');
                    $('label#'+field+'-error').remove();
                    $('[name="'+field+'"]').parent().append('<label id="'+field+'-error" class="has-error" for="'+field+'" >Campo de preenchimento obrigat&oacute;rio.</label>');
                }
            }
        });
        return {"error" : erro_validacao,"msg" : retorno_erro_validacao}
    }

    /*Export CSV, PDF, EXCEL*/
    let exports = function(){
        $(document).on('click','.export', function(){
            let data = $('#wsearch').serialize()
            var format = $(this).data('export')
            var url = APP_URL + '/export/'+format+'?'+data
            window.open(url,'_BLANK')
            //window.location.href = url
        })
    }
    /*Save */
    let save = function(){

        $("#save").click(function(){

            let data = $('.save').serialize()
            let id = $('.save').data("id")
            if(id){
                var url = APP_URL + '/' + controller() + '/' + id
            }else{
                var url = APP_URL + '/' + controller()
            }

            var required = info('.save')
            if(required.error == true){
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    html: required.msg,
                })
            }else{
                Swal.fire({
                    title: 'Todos os dados estão corretos?',
                    text: "Não será possível reverter esta ação!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    cancelButtonText: `Não`,
                    confirmButtonText: 'Sim'
                }).then((result) => {
                    if (result.value===true) {
                        $.ajax({
                            url:url,
                            method:'POST',
                            data:data,
                            success:function(response){
                                console.log(response)
                                if(response.success){
                                        Swal.fire({
                                            //position: 'top-end',
                                            icon: 'success',
                                            title: 'Sucesso!',
                                            //timer: 1500,
                                            text: response.message,
                                            //showConfirmButton: false,
                                        })
                                }else{
                                    console.log(response)
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro!',
                                        text: response.message,
                                    })
                                }
                            },
                            error:function(error){
                                console.log(error)
                                var retorno_erro_validacao = ''
                                 $.each(error.responseJSON.errors, function (key, value) {
                                     $('[name='+key+']').addClass('has-error')
                                     $('[name='+key+']').parent().children().addClass('has-error')
                                     $('[name='+key+']').parent().append('<label id="'+key+'-error" class="error" for="'+key+'">O valor indicado já existe no banco de dados.</label>')
                                     var text = $('[name='+key+']').data('name')
                                     retorno_erro_validacao +='<p class="text-danger"><i class="fas fa-exclamation-triangle"></i> O valor do campo <strong>'+text+ '</strong> já existe no banco de dados.</p>';
                                 });
                                 Swal.fire({
                                     icon: 'error',
                                     title: 'Erro!',
                                     html: retorno_erro_validacao,
                                 })
                             }
                        })
                    }
                })
            }
        })
    }
    /*Save end out */
    let save_out = function(){
        $("#save_out").click(function(){
            //e.preventDefault()
            let data = $('.save').serialize()
            let id = $('.save').data("id")

            if(id){
                var url = APP_URL + '/' + controller() + '/' + id
            }else{
                var url = APP_URL + '/' + controller()
            }
            var required = info('.save')

            if(required.error == true){
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    html: required.msg,
                })
            }else{
                Swal.fire({
                    title: 'Todos os dados estão corretos?',
                    text: "Não será possível reverter esta ação!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    cancelButtonText: `Não`,
                    confirmButtonText: 'Sim'
                }).then((result) => {
                    if (result.value===true) {
                        $.ajax({
                            url:url,
                            method:'POST',
                            data:data,
                            success:function(response){
                                if(response.success){
                                    console.log(response)
                                        Swal.fire({
                                            //position: 'top-end',
                                            icon: 'success',
                                            title: 'Sucesso!',
                                            //timer: 1500,
                                            text: response.message,
                                            //showConfirmButton: false,
                                        }).then((result) => {
                                            window.location.href = response.location
                                        })
                                }else{
                                    console.log(response)
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro!',
                                        text: response.message,
                                    })
                                }
                            },
                            error:function(error){
                                console.log(error)
                               var retorno_erro_validacao = ''
                                $.each(error.responseJSON.errors, function (key, value) {
                                    $('[name='+key+']').addClass('has-error')
                                    $('[name='+key+']').parent().children().addClass('has-error')
                                    $('[name='+key+']').parent().append('<label id="'+key+'-error" class="error" for="'+key+'">O valor indicado já existe no banco de dados.</label>')
                                    var text = $('[name='+key+']').data('name')
                                    retorno_erro_validacao +='<p class="text-danger"><i class="fas fa-exclamation-triangle"></i> O valor do campo <strong>'+text+ '</strong> já existe no banco de dados.</p>';
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro!',
                                    html: retorno_erro_validacao,
                                })
                            }
                        })
                    }
                })
            }
        })
    }
    /*Visualizar o modal */
    let show = function(){
        $(document).on('click','.viewModel', function(){
            let id = $(this).attr("data-id")
            var url = APP_URL + '/' + controller() + '/' + id
            $.ajax({
                url:url,
                method:'GET',
                success:function(response){

                    if(response.success){
                        $('#modalView').modal('show')
                        $('#modalView .modal-title').html('<i class="fas fa-user"></i> '+ response.data.title)
                        $('#modalView .modal-body #body').html('')
                        $('#modalView .modal-body #body').append('<div class="col"><div class="row" id="itens"></div></div>')
                        for (const key in response.data.body) {
                            if(key=='image'){
                                $('#modalView .modal-body #body').append(
                                    '<div class="col text-center">'+
                                        '<img class="w-50" src="'+response.data.body[key]+'">'+
                                    '</div>'
                                )
                            }else{
                                $('#modalView .modal-body #itens').append(
                                    '<div class="col-lg-6" >'+
                                    '<h4 ><strong>'+key+':</strong></h4>'+
                                    '<h5 >'+response.data.body[key]+'</h5>'+
                                    '</div>'
                                )
                            }
                        }
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: response.message,
                        })
                    }
                },
                error:function(error){
                    console.log(error)
                }
            })
        })
    }
    /*Delete */
    let del = function(){
        $(document).on('click','.delete', function(){
            let id = $(this).attr("data-id")

            if(id){
                var url = APP_URL + '/' + controller() + '/' + id
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Selecione um arquivo válido.',
                })
            }
            Swal.fire({
                title: 'Tem certeza que deseja excluir este arquivo?',
                text: "Não será possível reverter esta ação!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                cancelButtonText: `Não`,
                confirmButtonText: 'Sim'
              }).then((result) => {
                  //console.log(result)
                if (result.value===true) {
                    $.ajax({
                        url:url,
                        method:'DELETE',
                        data:{id:id},
                        success:function(response){
                        console.log(response)
                            if(response.success){
                                    Swal.fire({
                                        //position: 'top-end',
                                        icon: 'success',
                                        title: 'Sucesso!',
                                        //timer: 1500,
                                        text: response.message,
                                        //showConfirmButton: false,
                                    }).then((result) => {
                                        window.location.href = response.location
                                    })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro!',
                                    text: response.message,
                                })
                            }
                        },
                        error:function(error){
                            console.log(error)
                        }
                    })
                }
              })
        })
    }
    /*Delete */
    let commitDelete = function(){
        $(document).on('click','.delete-commit', function(){
            let id = $(this).attr("data-id")

            if(id){
                var url = APP_URL + '/' + controller() + '/' + id
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Selecione um arquivo válido.',
                })
            }
            Swal.mixin({
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                cancelButtonText: `Não`,
                confirmButtonText: 'Sim',
                input: 'text',
              }).queue([
                {
                    title: 'Tem certeza que deseja excluir este arquivo?',
                    text: "Não será possível reverter esta ação!",
                },
              ]).then((result) => {
                if (result.value) {
                    if(result.value != ''){
                        $.ajax({
                            url:url,
                            method:'DELETE',
                            data:{id:id,motive:result.value[0]},
                            success:function(response){
                                if(response.success){
                                        Swal.fire({
                                            //position: 'top-end',
                                            icon: 'success',
                                            title: 'Sucesso!',
                                            //timer: 1500,
                                            text: response.message,
                                            //showConfirmButton: false,
                                        }).then((result) => {
                                            window.location.href = response.location
                                        })
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro!',
                                        text: response.message,
                                    })
                                }
                            },
                            error:function(error){
                                console.log(error)
                            }
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Por favor, escreva o motivo da exclusão.',
                        })
                    }
                }
              })
        })
    }
/*Save */
let send_response = function(){

    $("#send").click(function(){

        let data = $('.save').serialize()
        let id = $('.save').data("id")
        var url = APP_URL + '/send-response/' + id

        var required = info('.save')
        if(required.error == true){
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                html: required.msg,
            })
        }else{
            Swal.fire({
                title: 'Tem certeza que deseja enviar o email?',
                text: "Não será possível reverter esta ação!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                cancelButtonText: `Não`,
                confirmButtonText: 'Sim'
            }).then((result) => {
                if (result.value===true) {
                    $.ajax({
                        url:url,
                        method:'POST',
                        data:data,
                        success:function(response){
                            console.log(response)
                            if(response.success){
                                    Swal.fire({
                                        //position: 'top-end',
                                        icon: 'success',
                                        title: 'Sucesso!',
                                        //timer: 1500,
                                        text: response.message,
                                        //showConfirmButton: false,
                                    })
                            }else{
                                console.log(response)
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro!',
                                    text: response.message,
                                })
                            }
                        },
                        error:function(error){
                            console.log(error)
                            var retorno_erro_validacao = ''
                             $.each(error.responseJSON.errors, function (key, value) {
                                 $('[name='+key+']').addClass('has-error')
                                 $('[name='+key+']').parent().children().addClass('has-error')
                                 $('[name='+key+']').parent().append('<label id="'+key+'-error" class="error" for="'+key+'">O valor indicado já existe no banco de dados.</label>')
                                 var text = $('[name='+key+']').data('name')
                                 retorno_erro_validacao +='<p class="text-danger"><i class="fas fa-exclamation-triangle"></i> O valor do campo <strong>'+text+ '</strong> já existe no banco de dados.</p>';
                             });
                             Swal.fire({
                                 icon: 'error',
                                 title: 'Erro!',
                                 html: retorno_erro_validacao,
                             })
                         }
                    })
                }
            })
        }
    })
}

    return{
      init: function(){
        save()
        save_out()
        show()
        del()
        commitDelete()
        //searchPartners()
        exports()
        send_response()
      }
    }
  }()

  jQuery(document).ready(function(){
    App_crud.init();
  })
