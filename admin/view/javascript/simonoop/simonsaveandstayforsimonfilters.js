/*
 * simonfilters - 2.12.0 Build 0001
*/

$(function(){
    if($(".buttons a").length>0){
        urlAjax = $("#form").attr("action");

        $("#simon_save_and_stay").click(function(event){
            event.preventDefault();
            $(".content").fadeTo(100, .2);
            $("span.error").remove();
            $("div.warning").remove();
            $.post(urlAjax, $("#form").serialize(),function(data){
                $data = $(data);
                if($data.find("span.error").length>0 || $data.find(".warning").length>0){
                    $data.find("span.error").each(function(i,e){
                        name = $(e).prevAll(":input").attr("name");
                        $control = $("[name='"+ name +"']");
                        
                        if($control.next("img").length>0){
                            $control.next("img").after(e)
                        }else{
                            $control.after(e);
                        }
                    });
                    $data.find("div.warning").each(function(i,e){
                        warning_class = $(e).prev().attr("class");
                        $("."+ warning_class).after(e);
                    });
                }else{
                    $("span.error").remove();
                }
                $(".content").fadeTo(100, 1);
            });
        });
    }
});