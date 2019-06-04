/**
 * Created by User on 28.05.2019.
 */

(function () {
    /*
        show and hide file with message
     */
    $('.btn-info').click(function () {
    $(this).next().next().toggleClass('visible1');
    });

    /*
        message preview
     */

    $('.btn-show').click(function () {
        if($(this).next().hasClass('visible1')){
            $(this).next().removeClass('visible1');
        }
        var message = $('.textarea').val().replace(/\n/g,'<br>');
        $(this).next().html(message);

    });
})();


