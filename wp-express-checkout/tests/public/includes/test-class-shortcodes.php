<?php

namespace WP_Express_Checkout;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2021-06-28 at 07:52:24.
 */
class ShortcodesTest extends \WP_UnitTestCase {

	/**
	 * @var Shortcodes
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	public function setUp() {
		$this->object = new Shortcodes;
	}

	/**
	 * @covers WP_Express_Checkout\Shortcodes::get_instance
	 */
	public function testGet_instance() {
		$this->assertInstanceOf( 'WP_Express_Checkout\Shortcodes', Shortcodes::get_instance() );
	}

	/**
	 * @covers WP_Express_Checkout\Shortcodes::shortcode_wp_express_checkout
	 * @todo   Implement testShortcode_wp_express_checkout().
	 */
	public function testShortcode_wp_express_checkout() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Shortcodes::generate_pp_express_checkout_button
	 * @todo   Implement testGenerate_pp_express_checkout_button().
	 */
	public function testGenerate_pp_express_checkout_button() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Shortcodes::generate_price_tag
	 * @todo   Implement testGenerate_price_tag().
	 */
	public function testGenerate_price_tag() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Shortcodes::shortcode_wpec_thank_you
	 * @todo   Implement testShortcode_wpec_thank_you().
	 */
	public function testShortcode_wpec_thank_you() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Shortcodes::generate_product_details_tag
	 * @todo   Implement testGenerate_product_details_tag().
	 */
	public function testGenerate_product_details_tag() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Shortcodes::locate_template
	 * @todo   Implement testLocate_template().
	 */
	public function testLocate_template() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

}
