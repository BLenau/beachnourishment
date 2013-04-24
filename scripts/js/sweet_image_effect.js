$(function(){
    $('.large_image').each(function(){
        $(this).hover(
             function(){
                $(this).stop(true).animate({
                    width: 590,
                    marginLeft: -398
                  }, 500 );
             },

             function(){
                $(this).stop(true).animate({
                    width: 192,
                    marginLeft: 0
                  }, 500 );
             }
        );
    });
});
