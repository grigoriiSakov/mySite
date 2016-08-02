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

        $(document).on("click","#login",function () { // авторизация пользователя
            $.getJSON("/page/login",{} , function (data) {
                $('.container').addClass("popup_overlay");
                $(".login").html(data);
                getWindow();
            })
        })
        $(document).on('click','#registration',function () { // выод формы регистрации пользователя
            $.getJSON('/page/registration', {}, function (data) {
                $(".login").html(data);
                getWindow();                
            })           
        })
        
        $(document).on('click','#submit_registration',function () { // регистрация пользователя
            $.post('/page/addRegistration',
                {   "csrf":$("input[name='csrf']").val(),
                    "login":$("input[name='login']").val(),
                    "name":$("input[name='name']").val(),
                    "email":$("input[name='email']").val(),
                    "password":$("input[name='password']").val(),
                    "password1":$("input[name='password1']").val()

            },
                function (data) {
                $(".login").html(data);
                getWindow();

            },
                'json')

        }) 
        
    }));

