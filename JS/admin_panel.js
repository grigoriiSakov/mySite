// добавление тегов br, a, img, end при добавлении и редактировании статей
if($(document).ready(function () {
        var files; // здесь будут хранится данные о загружаемых файлах
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
            
        })
        // 
        function addBbcode(text, code) {
            $("textarea[name='content']").val($("textarea[name='content']").val().replace(text,code));
            $("input[name='bb_code']").remove();   
        }
        // insert [b][b/] code
        $(document).on('click', "#tag_b", function () {
        var text = $("input[name='bb_code']").val();
         var out = "[b]" + text + "[/b]";
            addBbcode(text,out);
            
        })
        // insert [end] code
        $(document).on('click', "#tag_end", function () {
            var text = $("input[name='bb_code']").val();
            var out =  text + "[end]";
            addBbcode(text,out);
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
            addBbcode(input_text_a,out);
            }
        );
        // insert [img] code
        $(document).on("click", "#tag_img", function () { // выводим форму для добавления картинки
            $("#window_tags_img").addClass("popup").css({'width': '300px','height': '150px','padding':'10px'});
            $(".input input[type='text']").css({ 'left':'25px', 'width': '200px'});
            $(".closer").css('right','5px');
            getWindow();
        })
        $('#file_img').change(function(){ // Вешаем функцию на событие Загрузки файла
            files = this.files;// Получим данные файлов и добавим их в переменную
        });
        $(document).on("click","#add_img", function (event) { // отправляем файл на сервер
                event.stopPropagation(); // Остановка происходящего
                event.preventDefault();  // Полная остановка происходящего

                // Создадим данные формы и добавим в них данные файлов из files
                var data = new FormData();
                $.each( files, function( key, value ){
                    data.append( key, value );
                });
                            // Отправляем запрос
                $.ajax({
                    url: '/admin/addImg',
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Не обрабатываем файлы (Don't process the files)
                    contentType: false, // Так jQuery скажет серверу что это строковой запрос
                    success: function(respond){
                         // Если все ОК
                        if( respond.error_load == false){// Файлы успешно загружены
                            var text = $("input[name='bb_code']").val();
                            if (typeof text === "undefined") {
                                text = $("textarea[name='content']").val();
                            }
                            var out =  text + "[img src='http://" +respond.host +"/img/"+respond.name+"'" +
                        "alt='" + respond.name +"']";
                            addBbcode(text,out);
                            $('.popup').fadeOut(400);//Закрываю всплывающее окно
                        }
                        else{
                            $("#error_load").html(respond.error_load).attr("style", "display:block");
                        }
                    
                    }
                });       
           
        })
    }));
