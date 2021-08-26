<?php

namespace WP_Express_Checkout;

require_once WPEC_TESTS_DIR . '/mocks/mock-product-type.php';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2021-06-28 at 07:52:57.
 *
 * @group products
 *
 * @covers WP_Express_Checkout\Products
 */
class ProductsTest extends \WP_UnitTestCase {

	/**
	 * @var Products
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	public function setUp() {
		$this->object = new Products;
	}

	/**
	 * @covers WP_Express_Checkout\Products::register_post_type
	 */
	public function testRegister_post_type() {
		unregister_post_type( Products::$products_slug );
		$this->assertNull( get_post_type_object( Products::$products_slug ) );
		Products::register_post_type();
		$this->assertInstanceOf( 'WP_Post_Type', get_post_type_object( Products::$products_slug ) );
	}

	/**
	 * @covers WP_Express_Checkout\Products::retrieve
	 */
	public function testRetrieve__non_numeric() {
		$this->expectExceptionCode( 1001 );
		Products::retrieve( 'not a number' );
	}

	/**
	 * @covers WP_Express_Checkout\Products::retrieve
	 */
	public function testRetrieve__no_data() {
		$this->expectExceptionCode( 1002 );
		Products::retrieve( 0 );
	}

	/**
	 * @covers WP_Express_Checkout\Products::retrieve
	 */
	public function testRetrieve__invalid_type() {
		$product_id = $this->factory->post->create(
			[
				'post_type' => 'post',
			]
		);
		$this->expectExceptionCode( 1002 );
		Products::retrieve( $product_id );
	}

	/**
	 * @covers WP_Express_Checkout\Products::retrieve
	 */
	public function testRetrieve__unknown_product_type() {
		$product_id = $this->factory->post->create(
			[
				'post_type' => \WP_Express_Checkout\Products::$products_slug,
				'meta_input' => [
					'wpec_product_type' => 'test'
				],
			]
		);
		$this->expectExceptionCode( 1003 );
		Products::retrieve( $product_id );
	}

	/**
	 * @covers WP_Express_Checkout\Products::retrieve
	 */
	public function testRetrieve__reflects_type_filter() {
		$product_id = $this->factory->post->create(
			[
				'post_type' => \WP_Express_Checkout\Products::$products_slug,
				'meta_input' => [
					'wpec_product_type' => 'test'
				],
			]
		);

		add_filter( 'wpec_product_type_test', [ $this, 'decorate_product' ] );
		$product = Products::retrieve( $product_id );
		remove_filter( 'wpec_product_type_test', [ $this, 'decorate_product' ] );

		$this->assertInstanceOf( 'WP_Express_Checkout\Products\Test_Product', $product );
	}

	/**
	 * @covers WP_Express_Checkout\Products::retrieve
	 */
	public function testRetrieve__reflects_type_default() {
		$product_id = $this->factory->post->create(
			[
				'post_type' => \WP_Express_Checkout\Products::$products_slug,
			]
		);

		$product = Products::retrieve( $product_id );

		$this->assertInstanceOf( 'WP_Express_Checkout\Products\One_Time_Product', $product );
	}


	/**
	 * @covers WP_Express_Checkout\Products::retrieve
	 */
	public function testRetrieve__reflects_type_one_time() {
		$product_id = $this->factory->post->create(
			[
				'post_type' => \WP_Express_Checkout\Products::$products_slug,
				'meta_input' => [
					'wpec_product_type' => 'one_time'
				],
			]
		);

		$product = Products::retrieve( $product_id );

		$this->assertInstanceOf( 'WP_Express_Checkout\Products\One_Time_Product', $product );
	}

	/**
	 * @covers WP_Express_Checkout\Products::retrieve
	 */
	public function testRetrieve__reflects_type_legacy_donation() {
		$product_id = $this->factory->post->create(
			[
				'post_type' => \WP_Express_Checkout\Products::$products_slug,
				'meta_input' => [
					'wpec_product_custom_amount' => 1
				],
			]
		);

		$product = Products::retrieve( $product_id );

		$this->assertInstanceOf( 'WP_Express_Checkout\Products\Donation_Product', $product );
	}

	/**
	 * @covers WP_Express_Checkout\Products::retrieve
	 */
	public function testRetrieve__reflects_type_donation() {
		$product_id = $this->factory->post->create(
			[
				'post_type' => \WP_Express_Checkout\Products::$products_slug,
				'meta_input' => [
					'wpec_product_type' => 'donation'
				],
			]
		);

		$product = Products::retrieve( $product_id );

		$this->assertInstanceOf( 'WP_Express_Checkout\Products\Donation_Product', $product );
	}

	/**
	 * @covers WP_Express_Checkout\Products::retrieve
	 * @covers WP_Express_Checkout\Integrations
	 */
	public function testRetrieve__fallback_type_subscription() {
		if ( !defined( 'WPEC_SUB_PLUGIN_VER' ) ) {
			define( 'WPEC_SUB_PLUGIN_VER', 1 );
		}

		new Integrations();

		$product_id = $this->factory->post->create(
			[
				'post_type' => \WP_Express_Checkout\Products::$products_slug,
				'meta_input' => [
					'wpec_product_type' => 'subscription'
				],
			]
		);

		$product = Products::retrieve( $product_id );

		$this->assertInstanceOf( 'WP_Express_Checkout\Products\One_Time_Product', $product );
	}

	public function decorate_product( $post ) {
		return new Products\Test_Product( $post );
	}

}
