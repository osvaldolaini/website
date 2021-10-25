var App_validate = function () {

    /*Required*/
    let inputRequired = function(){
        $('.form-control').blur(function(){
            var val = $(this).val()
            var req = $(this).prop('required')
            var field = $(this).attr('name');
            $('label#'+field+'-error').remove();
            if(val){
                $(this).parent().children().removeClass('has-error')
                $(this).parent().children().addClass('has-success')
            }else{
                if(req){
                    $(this).parent().children().removeClass('has-success')
                    $(this).parent().children().addClass('has-error')
                    $('[name="'+field+'"]').parent().append('<label id="'+field+'-error" class="has-error" for="'+field+'" >Campo de preenchimento obrigat&oacute;rio.</label>');
                }
            }
        })
    }
    /*Email validator */
    let validateEmail = function(){
        $("[type=email]").keyup(function(){
            var email = $(this).val()
            var re = /\S+@\S+\.\S+/;
            $("label#email-error").remove();
            if(re.test(email)==false){
                $('[name=email]').parent().append('<label id="email-error" class="has-error" for="email" >Email invalido.</label>');
            }
        })
        $("[type=email]").change(function(){
            var email = $(this).val()
            var re = /\S+@\S+\.\S+/;
            $("label#email-error").remove();
            if(re.test(email)==false){
                $('[name=email]').val('');
            }
        })
    }
    let validatePhone = function (){
        $(".phones").change(function(){
            var number = $(this).val()
            number = number.replace(/[^\d]+/g,'');
            var name = $(this).attr('name');
            if(number.length < 10){
                $('[name='+name+']').val('');
            }
        })
    }
    /*CPF validator */
    let validateCPF = function(){
        $("[name=name]").keyup(function(){
            var cpf = $(this).val()
            $("label#cpf-error").remove();
            cpf = cpf.replace(/[^\d]+/g,'');
            if(testCpf(cpf)==false){
                $('[name=cpf]').parent().append('<label id="cpf-error" class="has-error" for="cpf" >Valor invalido.</label>');
            }
        })
        $("[name=cpf]").blur(function(){
            var cpf = $(this).val()
            cpf = cpf.replace(/[^\d]+/g,'');
            if(cpf.length < 11){
                $("label#cpf-error").remove();
                $('[name=cpf]').val('');
            }
        })
            function testCpf(strCPF) {
                var Soma;
                var Resto;
                Soma = 0;
              if(strCPF == "00000000000" ||
                strCPF == "11111111111" ||
                strCPF == "22222222222" ||
                strCPF == "33333333333" ||
                strCPF == "44444444444" ||
                strCPF == "55555555555" ||
                strCPF == "66666666666" ||
                strCPF == "77777777777" ||
                strCPF == "88888888888" ||
                strCPF == "99999999999") return false;

              for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
              Resto = (Soma * 10) % 11;
                // Valida 1o digito
                if ((Resto == 10) || (Resto == 11))  Resto = 0;
                if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

              Soma = 0;
                for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
                Resto = (Soma * 10) % 11;
                // Valida 2o digito
                if ((Resto == 10) || (Resto == 11))  Resto = 0;
                if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
                return true;
            }
    }
    return{
      init: function(){
        validateCPF()
        validateEmail()
        validatePhone()
        inputRequired()
      }
    }
  }()

  jQuery(document).ready(function(){
    App_validate.init();
  })
