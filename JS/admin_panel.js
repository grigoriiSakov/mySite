// добавление тегов br, a, img, end при добавлении и редактировании статей
if($(document).ready(function () {

      // выбор выделенного текста внутри элемента;
        function getSelectedText(){
            var text = "";
            if (window.getSelection) {
                text = window.getSelection();
            }else if (document.getSelection) {
                text = document.getSelection();
            }else if (document.selection) {
                text = document.selection.createRange().text;
            }
            return text;
        }
        function getWindow() {
            $('.popup').fadeIn(400); //показываем всплывающее окно
            $('.closer').click(function () {
                $('.popup').fadeOut(400);

            });
        }
   //  если был выделен текст, то дальше бу[дет вставка тега
        $(document).on('select', "textarea[ name ='content']", function () {
            $("<input type ='hidden' name = 'bb_code'>").appendTo($("form")).val(getSelectedText()) ;
            //alert (str);
        })
        // insert [b][b/] code
        $(document).on('click', "#tag_b", function () {
        var text = $("input[name='bb_code']").val();
         var out = "[b]" + text + "[/b]";
            $("textarea[name='content']").val($("textarea[name='content']").val().replace(text,out));
            $("input[name='bb_code']").remove();
        })
        // insert [end] code
        $(document).on('click', "#tag_end", function () {
            var text = $("input[name='bb_code']").val();
            var out =  text + "[end]";
            $("textarea[name='content']").val($("textarea[name='content']").val().replace(text,out));
            $("input[name='bb_code']").remove();
        })
        //insert [a] code
        $(document).on('click', "#tag_a", function () {
                        $("#window_tags_a").addClass("popup").css({'width': '300px','height': '150px','padding':'10px'});
            $(".input input[type='text']").css({ 'left':'25px', 'width': '200px'});
            $(".closer").css('right','5px');
            $("#input_text_a").val($("input[name='bb_code']").val()); // вводим выделенный текст, который будет ссылкой
            getWindow();
        })
        $(document).on('click','#window_supmit',function () { // add tag
            $('.popup').fadeOut(400);//Закрываю всплывающее окно
            var input_link_a = $("#input_link_a").val();//Сохраняю введенную ссылку
            var input_text_a = $("#input_text_a").val();//Сохраняю введенный текст
            var out= "[a url='"+input_link_a+"']"+input_text_a+"[/a]";//Вставляю в форму bb тег ссылки
            $("textarea[name='content']").val($("textarea[name='content']").val().replace(input_text_a,out));
            $("input[name='bb_code']").remove();
            }
        );
    }));
