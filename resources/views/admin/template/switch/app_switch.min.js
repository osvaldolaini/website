var Switch = function () {
    /*Excluir imagem */
    let inputCheckbox = function(){
        $(".switch").click(function() {
        if( $("#slider").is(":checked") == true){
            $('#active').val("1");
            $('.slider i').removeClass("fa-thumbs-down");
            $('.slider i').addClass("fa-thumbs-up");
        }else{
            $('#active').val("0");
            $('.slider i').removeClass("fa-thumbs-up");
            $('.slider i').addClass("fa-thumbs-down");
        }
        });
    }

    return{
        init: function(){
            inputCheckbox()
        }
    }
}()
jQuery(document).ready(function(){
    Switch.init()
})
