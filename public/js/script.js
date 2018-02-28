jQuery( document ).ready( function( $ ) {
    $( '#vav-converter-calculate-button' ).click( function() {

        if ( $( this ).hasClass( 'disabled' ) ) {
            return false;
        }
        $( this ).addClass( 'disabled' );

        var sum = $( '#vav-converter-sum' ).val();

        if ( "" === $.trim( sum ) ) {
            $( '#vav-converter-sum' ).focus();
            alert( vav_data.text.empty_field_sum );
            $( this ).removeClass( 'disabled' );

            return false;
        }

        if ( ! $.isNumeric( sum ) ) {
            $( '#vav-converter-sum' ).focus();
            alert( vav_data.text.wrong_field_sum );
            $( this ).removeClass( 'disabled' );

            return false;
        }

        $.post(
            vav_data.admin_ajax_url,
            {
                action : 'vav_calculate',
                from : $( '#vav-converter-currency-from' ).val(),
                to : $( '#vav-converter-currency-to' ).val(),
                sum : $( '#vav-converter-sum' ).val()
            },
            function( data ) {
                $( '#vav-converter-calculate-button' ).removeClass( 'disabled' );

                if ( data !== null && data.success === true ) {
                    $( '#vav-converter-result' ).val( data.result );
                }
                else {
                    alert( data.result );
                }
            }, "json"
        );
    });

    $( '#vav-converter-sum' ).change( function() {
        var sum = $( this ).val();
        $( this ).val( sum.replace( ',', '.' ) );
    });

    $( '#vav-converter-currency-to' ).change( function() {
        $( '#vav-converter-result' ).val( "" );
    });
});