
(function ($) {
    "use strict";
    
    /* ------------------------------------------------------------------------- *
     * COMMON VARIABLES
     * ------------------------------------------------------------------------- */
    var $wn = $(window),
        $document = $(document),
        $body = $('body');

    $(function () {

        /* ------------------------------------------------------------------------- *
         * CHAT
         * ------------------------------------------------------------------------- */
        var $chatItems = $('.chat--items');

        if ( $chatItems.length ) {
            $chatItems.scrollTop( $chatItems.outerHeight() );
        }
    });

}(jQuery));
