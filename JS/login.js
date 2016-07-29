/**
 * Created by grigorii on 27.07.16.
 */

if( $(document).ready(function () {
        function getWindow() {
            $('.popup,.popup_overlay').fadeIn(400); //показываем всплывающее окно
            $('.closer').click(function () {
                $('.popup,.popup_overlay').fadeOut(400, function () {//скрываем всплывающее окно
                    $('.container').removeClass("popup_overlay").fadeIn(100);
                })

            });
        }

        $('#login').click(function () { // авторизация пользователя
            $.getJSON("/page/login",{} , function (data) {
                $('.container').addClass("popup_overlay");
                $(".login").html(data);
                getWindow();
            })
        })
        $(document).on('click','#registration',function () { // регистрация пользователя
            $.getJSON('/page/registration', {}, function (data) {
                $(".login").html(data);
                getWindow();                
            })           
        })
        
        $(document).on('click','#submit_registration',function () { // регистрация пользователя
            $.post('/page/addRegistration', {}, function (data) {
                alert(json(data));
                //$(".login").html(data);
                //getWindow();

            })

        }) 
        
    }));

