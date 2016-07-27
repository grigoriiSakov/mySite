/**
 * Created by grigorii on 27.07.16.
 */

if( $(document).ready(function () {

        $('#login').click(function () {
            $.get("/page/login",{} , function (data) {
                $('.container').addClass("popup_overlay");
                $(".login").html(data);
                $('.popup,.popup_overlay').fadeIn(400); //показываем всплывающее окно
                $('.closer,.popup_overlay').click(function(){
                    $('.popup,.popup_overlay').fadeOut(400, function () {//скрываем всплывающее окно
                        $('.container').removeClass("popup_overlay").fadeIn(100);

                    })


                });


            })
        })
    }));

