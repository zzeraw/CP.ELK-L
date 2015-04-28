$( function() {
    // $.stellar();
    $( '.fancybox-image-link' ).fancybox();

    var arr = [];

    $( document ).scroll( function () {
        var y = $( this ).scrollTop();

        if (arr.length <= 1) {
            arr.push(y);
        }

        if (arr.length > 1) {
            if ( y > 600 ) {
                $( '#navbarContacts' ).fadeIn();
            } else {
                $( '#navbarContacts' ).fadeOut();
            }
        }
    });

});

