<?php
/**
 * Created by Alexander Vitkalov
 * User: Alexander Vitkalov
 * Date: 05.09.2017
 * Time: 12:55
 */
global $vav_converter;
$currencies = $vav_converter->manager->get_currencies();
if ( count( $currencies ) > 1 ) {
?>
<div class="vav-converter">
	<h4><?php _e( 'Currency calculator', 'converter' ) ?></h4>
	<div class="vav-converter-calculator">
		<div class="vav-converter-calculator-from">
			<input type="text" value="1" id="vav-converter-sum" placeholder="<?php _e( 'Sum', 'converter' ) ?>">
			<select id="vav-converter-currency-from">
				<?php foreach ( $currencies as $currency ) { ?>
					<option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="vav-converter-calculator-text">
			<span><?php _e( 'exchange for', 'converter' ) ?></span>
		</div>
		<div class="vav-converter-calculator-to">
			<select id="vav-converter-currency-to">
				<?php foreach ( $currencies as $currency ) { ?>
					<option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
				<?php } ?>
			</select>
			<input type="text" value="" id="vav-converter-result" placeholder="0">
		</div>
		<div class="vav-converter-calculator-button">
			<button class="button button-primary" id="vav-converter-calculate-button">
				<?php _e( 'Calculate', 'converter' ) ?></button>
		</div>
	</div>
</div>
<?php } ?>