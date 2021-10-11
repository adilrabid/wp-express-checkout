<?php

namespace WP_Express_Checkout\Integrations;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2021-09-03 at 07:01:17.
 *
 * @group integrations
 * @group woocommerce
 *
 * @covers WP_Express_Checkout\Integrations\WooCommerce_Gateway
 */
class WooCommerce_GatewayTest extends \WP_UnitTestCase {

	/**
	 * @var WooCommerce_Gateway
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	public function setUp() {

		if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
			require_once WPEC_TESTS_DIR . '/mocks/mock-wc-payment-gateway.php';
			require_once WPEC_TESTS_DIR . '/mocks/mock-wc.php';
			require_once WPEC_TESTS_DIR . '/mocks/mock-wc-order.php';
		}

		$this->object = new WooCommerce_Gateway;
	}

	/**
	 * @covers WP_Express_Checkout\Integrations\WooCommerce_Gateway::add_wc_gateway_class
	 */
	public function testAdd_wc_gateway_class() {
		$methods = $this->object->add_wc_gateway_class( [] );
		$this->assertEquals( [ get_class( $this->object ) ], $methods );
	}

	/**
	 * @covers WP_Express_Checkout\Integrations\WooCommerce_Gateway::log
	 * @todo   Implement testLog().
	 */
	public function testLog() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Integrations\WooCommerce_Gateway::init_form_fields
	 */
	public function testInit_form_fields() {
		$this->object->init_form_fields();
		$this->assertNonEmptyMultidimensionalArray( $this->object->form_fields );
		$this->assertArrayHasKey( 'enabled', $this->object->form_fields );
	}

	/**
	 * @covers WP_Express_Checkout\Integrations\WooCommerce_Gateway::receipt_page
	 * @todo   Implement testReceipt_page().
	 */
	public function testReceipt_page() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Integrations\WooCommerce_Gateway::paypal_sdk_args
	 * @todo   Implement testPaypal_sdk_args().
	 */
	public function testPaypal_sdk_args() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Integrations\WooCommerce_Gateway::process_payment
	 */
	public function testProcess_payment() {
		$result = $this->object->process_payment( null );
		$this->assertEquals( [
			'result'   => 'success',
			'redirect' => 'http://example/test_checkout_payment_url',
		], $result );
	}

	/**
	 * @covers WP_Express_Checkout\Integrations\WooCommerce_Gateway::modal_window_title
	 */
	public function testModal_window_title() {
		$title = $this->object->get_option( 'popup_title' );
		$this->assertEquals( $title, $this->object->modal_window_title( $title, [] ) );
		$this->assertEquals( 'pop up it', $this->object->modal_window_title( 'pop up it', ['product_id' => 1] ) );
	}

}