<?php
/**
 * Payment form template
 *
 * @package wp-express-checkout
 */
?>

<div style="position: relative;" class="wp-ppec-shortcode-container" data-ppec-button-id="<?php echo esc_attr( $button_id ); ?>">

	<div class="wp-ppec-overlay" data-ppec-button-id="<?php echo esc_attr( $button_id ); ?>">
		<div class="wp-ppec-spinner">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>

	<?php if ( $custom_quantity ) { ?>
		<div>
			<label><?php esc_html_e( 'Quantity:', 'wp-express-checkout' ); ?></label>
			<input id="wp-ppec-custom-quantity" data-ppec-button-id="<?php echo esc_attr( $button_id ); ?>" type="number" name="custom-quantity" class="wp-ppec-input wp-ppec-custom-quantity" min="1" value="<?php echo esc_attr( $quantity ); ?>">
			<div class="wp-ppec-form-error-msg"></div>
		</div>
	<?php } ?>

	<?php if ( $custom_amount ) { ?>
		<?php $step = pow( 10, -intval( $this->ppdg->get_setting( 'price_decimals_num' ) ) ); ?>
		<div class="wpec-custom-amount-section">
			<span class="wpec-custom-amount-label-field">
				<label><?php echo esc_html(  sprintf( __( 'Enter Amount (%s): ', 'wp-express-checkout' ), $currency ) ); ?></label>
			</span>
			<span class="wpec-custom-amount-input-field">
				<input id="wp-ppec-custom-amount" data-ppec-button-id="<?php echo esc_attr( $button_id ); ?>" type="number" step="<?php echo esc_attr( $step ); ?>" name="custom-quantity" class="wp-ppec-input wp-ppec-custom-amount" min="0" value="<?php echo esc_attr( $price ); ?>">
			</span>
			<div class="wp-ppec-form-error-msg"></div>
		</div>
	<?php } ?>

	<?php
	// Variations.
	if ( ! empty( $variations['names'] ) ) {
		// we got variations for this product.
		foreach ( $variations['groups'] as $grp_id => $group ) {
			?>
			<div class="wpec-product-variations-cont">
				<label class="wpec-product-variations-label"><?php echo esc_attr( $group ); ?></label>
				<?php
				if ( ! empty( $variations['opts'][ $grp_id ] ) ) {
					// radio buttons output.
					foreach ( $variations['names'][ $grp_id ] as $var_id => $var_name ) {
						?>
						<label class="wpec-product-variations-select-radio-label">
							<input class="wpec-product-variations-select-radio" data-wpec-variations-group-id="<?php echo esc_attr( $grp_id ); ?>" name="wpecVariations[<?php echo esc_attr( $grp_id ); ?>][]" type="radio" name="123" value="<?php echo esc_attr( $var_id ); ?>" <?php checked( $var_id === 0 ); ?>>
							<?php echo esc_html( $var_name ); ?>
							<?php echo esc_html( WPEC_Utility_Functions::price_modifier( $variations['prices'][ $grp_id ][ $var_id ], $currency ) ); ?>
						</label>
					<?php
					}

				} else {
					// drop-down output.
					?>
					<select class="wpec-product-variations-select" data-wpec-variations-group-id="<?php echo esc_attr( $grp_id ); ?>" name="wpecVariations[<?php echo esc_attr( $grp_id ); ?>][]">
					<?php
					foreach ( $variations['names'][ $grp_id ] as $var_id => $var_name ) {
						?>
						<option value="<?php echo esc_attr( $var_id ); ?>"><?php echo esc_html( $var_name ); ?> <?php echo esc_html( WPEC_Utility_Functions::price_modifier( $variations['prices'][ $grp_id ][ $var_id ], $currency ) ); ?></option>
						<?php
					}
					?>
					</select>
					<?php
				}
			?>
			</div>
			<?php
		}
	}
	?>

	<?php if ( $coupons_enabled ) { ?>
		<div class="wpec_product_coupon_input_container">
			<label class="wpec_product_coupon_field_label"><?php esc_html_e( 'Coupon Code:', 'wp-express-checkout' ); ?> </label>
			<input id="wpec-coupon-field-<?php echo esc_attr( $button_id ); ?>" class="wpec_product_coupon_field_input" type="text" name="wpec_coupon">
			<input type="button" id="wpec-redeem-coupon-btn-<?php echo esc_attr( $button_id ); ?>" type="button" class="wpec_coupon_apply_btn" value="<?php esc_attr_e( 'Apply', 'wp-express-checkout' ); ?>">
			<div id="wpec-coupon-info-<?php echo esc_attr( $button_id ); ?>" class="wpec_product_coupon_info"></div>
		</div>
	<?php } ?>

	<div id="wp-ppdg-dialog-message" title="">
		<p id="wp-ppdg-dialog-msg"></p>
	</div>

	<div class = "wp-ppec-button-container">

		<?php if ( $this->ppdg->get_setting( 'tos_enabled' ) ) { ?>
			<div class="wpec_product_tos_input_container">
				<label class="wpec_product_tos_label">
					<input id="wpec-tos-<?php echo esc_attr( $button_id ); ?>" class="wpec_product_tos_input" type="checkbox"> <?php echo html_entity_decode( $this->ppdg->get_setting( 'tos_text' ) ); ?>
				</label>
				<div class="wp-ppec-form-error-msg"></div>
			</div>
		<?php } ?>

		<div id="<?php echo esc_attr( $button_id ); ?>" style="max-width:<?php echo esc_attr( $btn_width ? $btn_width . 'px;' : '' ); ?>"></div>

		<div class="wpec-button-placeholder" style="border: 1px solid #E7E9EB; padding:1rem;">
			<i><?php esc_html_e( 'This is where the Express Checkout Button will show. View it on the front-end to see how it will look to your visitors', 'wp-express-checkout' ); ?></i>
		</div>

	</div>

</div>