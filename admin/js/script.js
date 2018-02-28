function adminConverterCheckField( prefix ) {
    var name = jQuery( '#admin-converter-' + prefix + 'name' ).val();
    var rate = jQuery( '#admin-converter-' + prefix + 'rate' ).val();

    if ( "" === jQuery.trim( name ) ) {
        jQuery( '#admin-converter-' + prefix + 'name' ).focus();
        alert( vav_data.text.empty_field_name );
        return false;
    }

    if ( "" === jQuery.trim( rate ) ) {
        jQuery( '#admin-converter-' + prefix + 'rate' ).focus();
        alert( vav_data.text.empty_field_rate );
        return false;
    }

    if ( ! jQuery.isNumeric( rate ) ) {
        jQuery( '#admin-converter-' + prefix + 'rate' ).focus();
        alert( vav_data.text.wrong_field_rate );
        return false;
    }

    return true;
}

function adminConverterSaveEdited( el ) {
    if ( jQuery( el ).hasClass( 'disabled' ) ) {
        return false;
    }
    jQuery( el ).addClass( 'disabled' );

    var result = adminConverterCheckField( 'edit-' );
    if (false === result) {
        jQuery( el ).removeClass( 'disabled' );
        return false;
    }

    jQuery.post(
        vav_data.admin_ajax_url,
        {
            action : 'vav_save_currency',
            id : jQuery( '#admin-converter-edit-id' ).val(),
            name : jQuery( '#admin-converter-edit-name' ).val(),
            rate : jQuery( '#admin-converter-edit-rate' ).val()
        },
        function( data ) {
            jQuery( el ).removeClass( 'disabled' );

            if ( data !== null && data.success === true ) {
                self.parent.tb_remove();
                location.reload();
            }
            else {
                jQuery( '#admin-converter-edit-info' ).text( data.result ).show().delay(5000).fadeOut();
            }
        }, "json"
    );
}

jQuery( document ).ready( function( $ ) {
    $( '#admin-converter-add-button' ).click( function() {

        if ( $( this ).hasClass( 'disabled' ) ) {
            return false;
        }
        $( this ).addClass( 'disabled' );

        var result = adminConverterCheckField( '' );
        if (false === result) {
            $( this ).removeClass( 'disabled' );
            return false;
        }

        $.post(
            vav_data.admin_ajax_url,
            {
                action : 'vav_save_currency',
                id : 0,
                name : $( '#admin-converter-name' ).val(),
                rate : $( '#admin-converter-rate' ).val()
            },
            function( data ) {
                $( this ).removeClass( 'disabled' );

                if ( data !== null && data.success === true ) {
                    $( '#admin-converter-name' ).val( '' );
                    $( '#admin-converter-rate' ).val( '' );
                    location.reload();
                }
                else {
                    alert( data.result );
                }
            }, "json"
        );
    });

    $( '#admin-converter-rate, #admin-converter-edit-rate' ).change( function() {
        var rate = $( this ).val();
        $( this ).val( rate.replace( ',', '.' ) );
    });

    $( '.admin-converter-edit-button' ).click( function() {
        var id = $( this ).data( 'id' );
        var name = $( '#row-id-' + id ).find( 'td' ).eq(0).html();
        var rate = $( '#row-id-' + id ).find( 'td' ).eq(1).html();
        $( '#admin-converter-edit-id' ).val( id );
        $( '#admin-converter-edit-name' ).val( name );
        $( '#admin-converter-edit-name-text' ).text( name );
        $( '#admin-converter-edit-rate' ).val( rate );

        var title = $( '#admin-converter-edit-modal-dialog' ).attr( 'title' );
        tb_show(title, '#TB_inline?&height=240&width=300&inlineId=admin-converter-edit-modal-dialog', 'null' );
        $( '#TB_ajaxContent' ).css( 'height', 'auto' );
    });

    $( '.admin-converter-delete-button' ).click( function() {
        var id = $( this ).data( 'id' );
        var name = $( '#row-id-' + id ).find( 'td' ).eq(0).html();
        var text = vav_data.text.confirm_delete;

        if ( false === confirm( text.replace( '%s', name ) ) ) {
            return false;
        }

        $.post(
            vav_data.admin_ajax_url,
            {
                action : 'vav_delete_currency',
                id : id
            },
            function( data ) {
                if ( data !== null && data.success === true ) {
                    location.reload();
                }
                else {
                    alert( data.result );
                }
            }, "json"
        );
    });
});