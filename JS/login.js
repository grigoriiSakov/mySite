/**
 * Created by grigorii on 27.07.16.
 */

if( $(document).ready(function () {

        $('#login').bind("click", function () {
            $.get("index.php",'page/login' , function (data) {
             alert(data);
            })
        })
    }));