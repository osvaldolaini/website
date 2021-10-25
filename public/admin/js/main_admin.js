const appurlmeta = document.querySelector("meta[name='app_url']");
const APP_URL = appurlmeta.getAttribute("content");
const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN
    }
});
$(document).ready(function() {
    /*Tooltip Bootstrap */
    $('[data-tooltip="tooltip"]').tooltip();
    $('body').tooltip({selector: '[data-tooltip="tooltip"]'});
})
function money(value){
    return new Intl.NumberFormat('pt-BR',{minimumFractionDigits: 2}).format(value).replace('R$','')
}
function dataDB(date){
    var date = date.split('/');
    return date[2]+'-'+date[1]+'-'+date[0]
}
var Main_admin = function () {
    //Buscar CEP  e completar os dados de endereço
    let cep = function(){
            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                    $('[name="address"]').val("");
                    $('[name="district"]').val("");
                    $('[name="city"]').val("");
                    $('[name="state"]').val("");
                    $('[name="number"]').val("");
            }

            //Quando o campo cep perde o foco.
            $("[name='postalCode']").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                            $('[name="address"]').val("...");
                            $('[name="district"]').val("...");
                            $('[name="city"]').val("...");
                            $('[name="state"]').val("...");
                            $('[name="number"]').val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $('[name="address"]').val(dados.logradouro)
                                $('[name="district"]').val(dados.bairro)
                                $('[name="city"]').val(dados.localidade)
                                $('[name="state"]').val(dados.uf)
                                $('[name="number"]').focus()

                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro!',
                                    text: 'CEP não encontrado.',
                                })
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Formato de CEP inválido.',
                        })
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
    }
    /*Mascaras das inputs */
    var masks = function(){
        $.getScript(APP_URL + "/admin/js/jquery.mask.min.js", function(){
            $('.date').mask('00/00/0000');
            $('.hour').mask('00:00');
            $('[name="postalCode"]').mask('00000-000');
            $('[name="cpf"]').mask('000.000.000-00');
            $('.money').mask('000.000.000.000.000,00', {reverse : true});
            var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            //funcao 9 digitos
            spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
            $('.phones').mask(SPMaskBehavior, spOptions);

            var cnpjmask = function (val) {
                return val.replace(/\D/g, '').length > 13 ? '00.000.000/0000-00' : '000.000.000-00000';
                },
                //funcao cpf / cnpj
                spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(cnpjmask.apply({}, arguments), options);
                    }
                };
                $('.cnpj').mask(cnpjmask, spOptions);
         });
      }
    return{
      init: function(){
        cep()
        masks()
      }
    }
  }()

  jQuery(document).ready(function(){
    Main_admin.init();
  })
