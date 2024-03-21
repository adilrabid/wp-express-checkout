<?php

namespace WP_Express_Checkout\Products;

use WP_Express_Checkout\Main;
use WP_Express_Checkout\Products;
use WP_UnitTestCase;
use WP_UnitTest_Factory_For_Post;
/**
 * Generated by PHPUnit_SkeletonGenerator on 2021-08-18 at 07:03:12.
 *
 * @group products
 *
 * @covers WP_Express_Checkout\Products\Product
 */
class ProductTest extends WP_UnitTestCase {

	/**
	 * @var Product
	 */
	protected $object;

	/**
	 * @var Product
	 */
	protected $post;
	protected $factory;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	public function setUp() :void{
		$this->factory = new WP_UnitTest_Factory_For_Post();

		$post = $this->factory->create_and_get(
			[
				'post_type' => Products::$products_slug,
				'meta_input' => [
					'wpec_product_type' => 'test',
					'wpec_product_resource_id' => 'test_resource_id',
					'ppec_product_quantity' => 42,
					'ppec_product_custom_quantity' => 1,
					'ppec_product_upload' => 'test_download_url',
					'wpec_product_thumbnail' => 'test_thumbnail_url',
					'wpec_product_shipping' => 4.2,
					'wpec_product_shipping_enable' => true,
					'wpec_product_tax' => 5.5,
					'wpec_product_thankyou_page' => 'test_thank_you_url',
					'wpec_product_button_text' => 'test_button_text',
					'wpec_product_button_type' => 'test_button_type',
					'wpec_product_coupons_setting' => '1',
					'wpec_download_duration' => '42',
					'wpec_download_count' => '24',
					'wpec_variations_groups' => [ 'test group' ],
					'wpec_variations_names' => [ [ 'test group name 1' ] ],
					'wpec_variations_prices' => [ [ '+1' ] ],
					'wpec_variations_urls' => [ [ '' ] ],
					'wpec_variations_opts' => [ [ '0' ]	],
				],
			]
		);
		$this->post   = $post;
		$this->object = new Test_Product( $post );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_type
	 */
	public function testGet_type() {
		$this->assertEquals( $this->post->wpec_product_type, $this->object->get_type() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_id
	 */
	public function testGet_id() {
		$this->assertEquals( $this->post->ID, $this->object->get_id() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_resource_id
	 */
	public function testGet_resource_id() {
		$this->assertEquals( 'test_resource_id', $this->object->get_resource_id() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::set_resource_id
	 */
	public function testSet_resource_id() {
		$this->object->set_resource_id( 'test_resource_id2' );
		$this->assertEquals( 'test_resource_id2', $this->object->get_resource_id() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::set_resource_id
	 */
	public function testSet_resource_id__not_a_string() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->set_resource_id( array( 'not-a-string' ) );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_quantity
	 */
	public function testGet_quantity() {
		$this->assertEquals( 42, $this->object->get_quantity() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::is_custom_quantity
	 */
	public function testIs_custom_quantity() {
		$this->assertEquals( true, $this->object->is_custom_quantity() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_download_url
	 */
	public function testGet_download_url() {
		$this->assertEquals( 'test_download_url', $this->object->get_download_url() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_download_duration
	 */
	public function testGet_download_duration__empty() {
		update_post_meta( $this->object->get_id(), 'wpec_download_duration', '' );
		$this->assertEquals( 0, $this->object->get_download_duration() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_download_duration
	 */
	public function testGet_download_duration() {
		$this->assertEquals( 42, $this->object->get_download_duration() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_download_duration
	 */
	public function testGet_download_duration__fallback_to_options() {
		update_option( 'ppdg-settings', array_merge( Main::get_defaults(), [ 'download_duration' => 4 ] ) );
		update_post_meta( $this->object->get_id(), 'wpec_download_duration', '0' );
		$this->assertEquals( 0, $this->object->get_download_duration() );
		update_post_meta( $this->object->get_id(), 'wpec_download_duration', '' );
		$this->assertEquals( 4, $this->object->get_download_duration() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_download_count
	 */
	public function testGet_download_count() {
		$this->assertEquals( 24, $this->object->get_download_count() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_download_count
	 */
	public function testGet_download_count__fallback_to_options() {
		update_option( 'ppdg-settings', array_merge( Main::get_defaults(), [ 'download_count' => 2 ] ) );
		update_post_meta( $this->object->get_id(), 'wpec_download_count', '0' );
		$this->assertEquals( 0, $this->object->get_download_count() );
		update_post_meta( $this->object->get_id(), 'wpec_download_count', '' );
		$this->assertEquals( 2, $this->object->get_download_count() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_thumbnail_url
	 */
	public function testGet_thumbnail_url() {
		$this->assertEquals( 'test_thumbnail_url', $this->object->get_thumbnail_url() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_shipping
	 */
	public function testGet_shipping() {
		$this->assertEquals( 4.2, $this->object->get_shipping() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_shipping
	 */
	public function testGet_shipping_fallback_to_settings() {
		update_option( 'ppdg-settings', array_merge( Main::get_defaults(), [ 'shipping' => 5 ] ) );
		update_post_meta( $this->object->get_id(), 'wpec_product_shipping', '' );
		$this->assertEquals( 5, $this->object->get_shipping() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::is_physical
	 */
	public function testIs_physical() {
		$this->assertEquals( true, $this->object->is_physical() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::is_digital_product
	 */
	public function testIs_digital_product() {
		$this->assertEquals( false, $this->object->is_digital_product() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_tax
	 */
	public function testGet_tax() {
		$this->assertEquals( 5.5, $this->object->get_tax() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_thank_you_url
	 */
	public function testGet_thank_you_url() {
		$this->assertEquals( 'test_thank_you_url', $this->object->get_thank_you_url() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_button_text
	 */
	public function testGet_button_text() {
		$this->assertEquals( 'test_button_text', $this->object->get_button_text() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_button_type
	 */
	public function testGet_button_type() {
		$this->assertEquals( 'test_button_type', $this->object->get_button_type() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_coupons_setting
	 */
	public function testGet_coupons_setting() {
		$this->assertEquals( '1', $this->object->get_coupons_setting() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_coupons_setting
	 */
	public function testGet_coupons_setting__fallback_to_options() {
		update_option( 'ppdg-settings', array_merge( Main::get_defaults(), [ 'coupons_enabled' => 'test_coupons_enabled' ] ) );
		update_post_meta( $this->object->get_id(), 'wpec_product_coupons_setting', '2' );
		$this->assertEquals( 'test_coupons_enabled', $this->object->get_coupons_setting() );
	}

	/**
	 * @covers WP_Express_Checkout\Products\Product::get_variations
	 */
	public function testGet_variations() {
		$exppected = [
			[
				"names"  => [ "test group name 1" ],
				"prices" => [ "+1" ],
				"urls"   => [ "" ],
				"opts"   => [ "0" ],
			],
			"groups" => [ "test group" ]
		];

		$this->assertEquals( $exppected, $this->object->get_variations() );
	}

}
