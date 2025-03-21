<?php

namespace WP_Express_Checkout;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2021-06-28 at 07:52:27.
 *
 * @covers WP_Express_Checkout\Main
 */
class MainTest extends \WP_UnitTestCase {

	/**
	 * @var Main
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	public function setUp() :void{
		$this->object = Main::get_instance();
	}

	/**
	 * @covers WP_Express_Checkout\Main::enqueue_styles
	 * @todo   Implement testEnqueue_styles().
	 */
	public function testEnqueue_styles() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Main::load_paypal_sdk
	 * @todo   Implement testLoad_paypal_sdk().
	 */
	public function testLoad_paypal_sdk() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Main::get_setting
	 */
	public function testGet_setting() {
		$dummy = $this->object->get_setting( 'dummy' );
		$this->assertFalse( $dummy );

		$is_live = $this->object->get_setting( 'is_live' );
		$this->assertEquals( 1, $is_live );

		update_option( 'ppdg-settings', array_merge( Main::get_defaults(), [ 'is_live' => 42 ] ) );

		$is_live = $this->object->get_setting( 'is_live' );
		$this->assertEquals( 42, $is_live );
		update_option( 'ppdg-settings', Main::get_defaults() );
	}

	/**
	 * @covers WP_Express_Checkout\Main::get_plugin_slug
	 * @todo   Implement testGet_plugin_slug().
	 */
	public function testGet_plugin_slug() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Main::get_instance
	 */
	public function testGet_instance() {
		$this->assertInstanceOf( 'WP_Express_Checkout\Main', Main::get_instance() );
	}

	/**
	 * @covers WP_Express_Checkout\Main::activate
	 * @todo   Implement testActivate().
	 */
	public function testActivate() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Main::deactivate
	 * @todo   Implement testDeactivate().
	 */
	public function testDeactivate() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Main::activate_new_site
	 * @todo   Implement testActivate_new_site().
	 */
	public function testActivate_new_site() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Main::get_defaults
	 */
	public function testGet_defaults() {
		$defaults = Main::get_defaults();
		$this->assertTrue( is_array( $defaults ) );
	}

	/**
	 * @covers WP_Express_Checkout\Main::check_and_create_thank_you_page
	 * @todo   Implement testCheck_and_create_thank_you_page().
	 */
	public function testCheck_and_create_thank_you_page() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Main::create_post
	 * @todo   Implement testCreate_post().
	 */
	public function testCreate_post() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Main::load_plugin_textdomain
	 * @todo   Implement testLoad_plugin_textdomain().
	 */
	public function testLoad_plugin_textdomain() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers WP_Express_Checkout\Main::rewrite_flush
	 * @todo   Implement testRewrite_flush().
	 */
	public function testRewrite_flush() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

}
