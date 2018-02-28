<?php
/**
 * Created by Alexander Vitkalov
 * User: Alexander Vitkalov
 * Date: 05.09.2017
 * Time: 12:16
 */
global $vav_converter;
$currencies = $vav_converter->manager->get_currencies();
?>
<div>
	<h2><?php echo __( 'Currency calculator', 'converter' ) ?></h2>
	<h4><?php echo __( 'Currency', 'converter' ) ?></h4>
    <div class="admin-converter-add">
        <input type="text" value="" id="admin-converter-name" placeholder="<?php _e( 'Name', 'converter' ) ?>" size="30">
        <input type="text" value="" id="admin-converter-rate" placeholder="<?php _e( 'Exchange rate to ruble', 'converter' ) ?>" size="20">
        <button class="button button-primary" id="admin-converter-add-button"><?php _e( 'Add', 'converter' ) ?></button>
    </div>
    <hr>
    <h4><?php echo __( 'Currency list', 'converter' ) ?></h4>
    <table class="admin-converter" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th><?php _e( 'Name', 'converter' ) ?></th>
            <th><?php _e( 'Rate', 'converter' ) ?></th>
            <th><?php _e( 'Actions', 'converter' ) ?></th>
        </tr>
        </thead>
        <tbody>
	    <?php if ( $currencies ) { ?>
		    <?php foreach ( $currencies as $currency ) { ?>
                <tr id="row-id-<?php echo $currency['id'] ?>">
                    <td><?php echo $currency['name'] ?></td>
                    <td><?php echo $currency['rate'] ?></td>
                    <td>
                        <button class="button button-primary admin-converter-edit-button"
                                data-id="<?php echo $currency['id'] ?>"><?php _e( 'Edit', 'converter' ) ?>
                        </button>
                        <button class="button admin-converter-delete-button"
                                data-id="<?php echo $currency['id'] ?>"><?php _e( 'Delete', 'converter' ) ?>
                        </button>
                    </td>
                </tr>
		    <?php }
	    }
	    else { ?>
            <tr>
                <td colspan="3"><?php _e( 'Empty list', 'converter' ) ?></td>
            </tr>
		<?php } ?>
        </tbody>
    </table>
</div>

<div id="admin-converter-edit-modal-dialog" title="<?php _e( 'Edit currency', 'converter' ); ?>" style="display:none;">
    <input type="hidden" id="admin-converter-edit-id" value="0">
    <div id="admin-converter-edit-info" style="display:none;"></div>
    <div style="padding-top: 5px">
        <span id="admin-converter-edit-name-text"></span>
        <table>
            <tr>
                <td width="100px"><b><?php _e( 'Name', 'converter' ) ?></b></td>
                <td><input type="text"
                           value="" id="admin-converter-edit-name"
                           placeholder="<?php _e( 'Name', 'converter' ) ?>" size="30"></td>
            </tr>
            <tr>
                <td width="100px"><b><?php _e( 'Rate', 'converter' ) ?></b></td>
                <td><input type="text"
                           value="" id="admin-converter-edit-rate"
                           placeholder="<?php _e( 'Name', 'converter' ) ?>" size="30"></td>
            </tr>
        </table>
    </div>
    <div class="admin-converter-edit-modal-dialog-buttons">
        <button class="button button-large button-primary"
           onclick="adminConverterSaveEdited( this );"><?php _e( 'Save', 'converter' ) ?></button>
        <button class="button button-large"
           onclick="self.parent.tb_remove();"
           style="margin-left: 5px;"><?php _e( 'Cancel', 'converter' ) ?></button>
    </div>
</div>