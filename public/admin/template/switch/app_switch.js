var Switch={init:function(){$(".switch").click(function(){1==$("#slider").is(":checked")?($("#active").val("1"),$(".slider i").removeClass("fa-thumbs-down"),$(".slider i").addClass("fa-thumbs-up")):($("#active").val("0"),$(".slider i").removeClass("fa-thumbs-up"),$(".slider i").addClass("fa-thumbs-down"))})}};jQuery(document).ready(function(){Switch.init()});
