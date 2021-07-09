<?php

namespace WP_Express_Checkout;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2021-06-28 at 07:52:36.
 *
 * @covers WP_Express_Checkout\Order
 */
class OrderTest extends \WP_UnitTestCase {

	/**
	 * @var Order
	 */
	protected $object;

	/**
	 * @var \WP_Post
	 */
	protected $post;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	public function setUp() {
		$this->post = $this->factory->post->create_and_get( [
			'meta_input' => [
				'wpec_ip_address' => '42.42.42',
				'wpec_order_customer_email' => 'dummy.user@example.com',
				'wpec_currency' => 'EUR',
			]
				] );
		$this->object = new Order( $this->post );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_info
	 */
	public function testGet_info() {
		$this->assertTrue( is_array( $this->object->get_info() ) );
		$this->assertEquals( $this->object->get_id(), $this->object->get_info( 'id' ) );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_id
	 */
	public function testGet_id() {
		$this->assertEquals( $this->post->ID, $this->object->get_id() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_description
	 */
	public function testGet_description() {
		$post = get_post( $this->object->get_id() );
		$this->assertEquals( $post->post_title, $this->object->get_description() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::set_description
	 */
	public function testSet_description() {
		$this->object->set_description( 'description for order' );
		$this->assertEquals( 'description for order', $this->object->get_description() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::set_description
	 */
	public function testSet_description__non_string_error() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->set_description( array( 'not-a-string' ) );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_item
	 */
	public function testAdd_item_reflects() {
		$status = $this->object->add_item( 'payment-test', 'payment-test', 5, 1, $this->object->get_id() );
		$this->assertTrue( $status );
		$this->assertCount( 1, $this->object->get_items() );

		$status = $this->object->add_item( 'new-type', 'new-type', 5 );
		$this->assertTrue( $status );
		$this->assertCount( 2, $this->object->get_items() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_item
	 */
	public function testAdd_item_no_post_id_reflects() {
		$status = $this->object->add_item( 'test', 'test', 5 );
		$this->assertTrue( $status );

		$item = $this->object->get_item( 0 );
		$this->assertEquals( $this->object->get_id(), $item['post_id'] );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_item
	 */
	public function testAdd_item_negative_total_reflects() {
		$this->object->add_item( 'test', 'test', -5 );
		$this->assertEquals( 0, $this->object->get_total() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_item
	 */
	public function testAdd_item_numeric_index_no_error() {
		$status = $this->object->add_item( 123, 42, 123 );
		$this->assertTrue( $status );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_item
	 */
	public function testAdd_item_unique_deletes_others() {
		$this->object->add_item( 'payment-test', 'payment-test', 5, 1, $this->object->get_id() );
		$this->object->add_item( 'payment-test', 'payment-test', 5, 1, $this->object->get_id() );

		$this->object->add_item( 'payment-test', 'payment-test', 15, 1, $this->object->get_id(), true );

		$this->assertCount( 1, $this->object->get_items() );
		$this->assertEquals( 15, $this->object->get_total() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_item
	 */
	public function testAdd_item_unqiue_only_deletes_same_type() {
		$this->object->add_item( 'payment-test1', 'payment-test1', 5, 1, $this->object->get_id() );
		$this->object->add_item( 'payment-test2', 'payment-test2', 10, 1, $this->object->get_id() );

		$this->object->add_item( 'payment-test2', 'payment-test2', 15, 1, $this->object->get_id(), true );

		$this->assertCount( 2, $this->object->get_items() );
		$this->assertEquals( 20, $this->object->get_total() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_item
	 */
	public function testAdd_item_quntity() {
		$this->object->add_item( 'payment-test', 'payment-test1', 5, 4, $this->object->get_id() );

		$this->assertCount( 1, $this->object->get_items() );
		$this->assertEquals( 20, $this->object->get_total() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_item
	 */
	public function testAdd_item_bad_type() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->add_item( array( 'not-a-string' ), '', 100, 1, 100 );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_item
	 */
	public function testAdd_item_bad_price() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->add_item( 'test', '', 'not-a-number', 1, 100 );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_item
	 */
	public function testAdd_item_bad_post() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->add_item( 'test', '', 100, 1, 'not-a-number' );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_item
	 */
	public function testAdd_item_bad_quantity() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->add_item( 'test', '', 100, 'not-a-number' );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_item
	 */
	public function testAdd_item_bad_meta() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->add_item( 'test', '', 100, 1, 1, true, 'not-an-array' );
	}

	/**
	 * @covers WP_Express_Checkout\Order::remove_item
	 */
	public function testRemove_item_by_type_reflects() {
		$this->object->add_item( 'payment-test', '', 5, 1, $this->object->get_id() );

		$this->object->remove_item( 'payment-test' );

		$this->assertCount( 0, $this->object->get_items() );
		$this->assertEquals( 0, $this->object->get_total() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::remove_item
	 */
	public function testRemove_item_multiple_by_type_reflects() {
		$this->object->add_item( 'payment-test', '', 5 );
		$this->object->add_item( 'payment-test', '', 4 );
		$this->object->add_item( 'payment-test', '', 3 );
		$this->object->add_item( 'payment-test', '', 2 );
		$this->object->add_item( 'payment-test', '', 1 );

		$this->object->remove_item( 'payment-test' );

		$this->assertCount( 0, $this->object->get_items() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::remove_item
	 */
	public function testRemove_item_by_price_reflects() {
		$this->object->add_item( 'payment-test', '', 5 );
		$this->object->add_item( 'payment-test', '', 4 );
		$this->object->add_item( 'payment-test1', '', 3 );
		$this->object->add_item( 'payment-test2', '', 2 );
		$this->object->add_item( 'payment-test3', '', 1 );

		$this->object->remove_item( '', 5 );

		$this->assertCount( 4, $this->object->get_items() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::remove_item
	 */
	public function testRemove_item_by_id_reflects() {
		$new_order = Orders::create();
		$this->object->add_item( 'payment-test', '', 5 );
		$this->object->add_item( 'payment-test', '', 4 );
		$this->object->add_item( 'payment-test1', '', 3, 1, $new_order->get_id() );
		$this->object->add_item( 'payment-test2', '', 2, 1, $new_order->get_id() );
		$this->object->add_item( 'payment-test3', '', 1, 1, $new_order->get_id() );

		$this->object->remove_item( '', '', $new_order->get_id() );

		$this->assertCount( 2, $this->object->get_items() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::remove_item
	 */
	public function testRemove_item_by_all_reflects() {
		$this->object->add_item( 'payment-test', '', 5 );
		$this->object->add_item( 'payment-test', '', 4 );
		$this->object->add_item( 'payment-test1', '', 3 );
		$this->object->add_item( 'payment-test2', '', 2 );
		$this->object->add_item( 'payment-test3', '', 1 );

		$this->object->remove_item();

		$this->assertCount( 0, $this->object->get_items() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::remove_item
	 */
	public function testRemove_item_bad_post() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->remove_item( '', 0, 'not-a-number' );
	}

	/**
	 * @covers WP_Express_Checkout\Order::remove_item
	 */
	public function testRemove_item_bad_price() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->remove_item( '', 'not-a-number' );
	}

	/**
	 * @covers WP_Express_Checkout\Order::remove_item
	 */
	public function testRemove_item_bad_type() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->remove_item( array( 'not-a-string' ) );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_item
	 */
	public function testGet_item_returns_correct_values() {
		$this->object->add_item( 'payment-test', '', 5, 1, $this->object->get_id() );

		$item = $this->object->get_item();
		$this->assertNotEmpty( $item );

		$this->assertArrayHasKey( 'price', $item );
		$this->assertEquals( 5, $item['price'] );

		$this->assertArrayHasKey( 'post_id', $item );
		$this->assertEquals( $this->object->get_id(), $item['post_id'] );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_item
	 */
	public function testGet_item_returns_correct_index() {
		$this->object->add_item( 'new-type-1', '', 5, 1, $this->object->get_id() );
		$this->object->add_item( 'new-type-2', '', 5, 1, $this->object->get_id() );

		$new_item = $this->object->get_item( 1 );
		$this->assertEquals( 'new-type-2', $new_item['type'] );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_item
	 */
	public function testGet_item_bad_type() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->get_items( [ 'some' ] );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_items
	 */
	public function testGet_items_returns_all_items(){
		$this->object->add_item( 'payment-test', '', 5, 1, $this->object->get_id() );
		$this->object->add_item( 'payment-test', '', 5, 1, $this->object->get_id() );
		$this->object->add_item( 'payment-test1', '', 5, 1, $this->object->get_id() );

		// Adding additional items should increase the count
		$this->assertCount( 3, $this->object->get_items() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_items
	 */
	public function testGet_items_filters_by_type(){
		$this->object->add_item( 'type-1', '', 1, 1, $this->object->get_id() );
		$this->object->add_item( 'type-2', '', 2, 1, $this->object->get_id() );
		$this->object->add_item( 'type-2', '', 3, 1, $this->object->get_id() );
		$this->object->add_item( 'type-3', '', 4, 1, $this->object->get_id() );
		$this->object->add_item( 'type-3', '', 5, 1, $this->object->get_id() );
		$this->object->add_item( 'type-3', '', 6, 1, $this->object->get_id() );

		// APP_Order::get_items should filter items properly
		$this->assertCount( 2, $this->object->get_items( 'type-2') );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_items
	 */
	public function testGet_items_bad_index_errors(){
		$this->object->add_item( 'test-item', '', 1, 1, $this->object->get_id() );

		// Getting a non-existant item should return false
		$this->assertFalse( $this->object->get_item( 10 ) );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_total
	 */
	public function testGet_total_default_zero(){
		$this->assertEquals( 0, $this->object->get_total() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_total
	 */
	public function testGet_total_reflects_added_items(){
		$this->object->add_item( 'payment-test', '', 5, 1, $this->object->get_id() );
		$this->assertEquals( 5, $this->object->get_total() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_total
	 */
	public function testGet_total_reflects_multiple_added_items(){
		$this->object->add_item( 'payment-test1', '', 5 );
		$this->object->add_item( 'payment-test2', '', 5 );

		$this->assertEquals( 10, $this->object->get_total() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_total
	 */
	public function testGet_total_reflects_decimals(){
		$this->object->add_item( 'payment-test', '', 6.99 );
		$this->object->add_item( 'payment-test', '', 5.99 );

		$this->assertEquals( 12.98, $this->object->get_total() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::set_currency
	 */
	public function testSet_currency() {
		$this->object->set_currency( 'DUMMY_CURR' );
		$this->assertEquals( 'DUMMY_CURR', $this->object->get_currency() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::set_currency
	 */
	function testSet_currency_non_string_errors(){
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->set_currency( array( 'not-a-string' ) );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_currency
	 */
	public function testGet_currency() {
		$this->object->set_currency( 'DUMMY_CURR' );
		$this->assertEquals( 'DUMMY_CURR', $this->object->get_currency() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_status
	 */
	public function testGet_status() {
		$this->assertEquals( 'incomplete', $this->object->get_status() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_display_status
	 */
	public function testGet_display_status() {
		$this->assertEquals( 'Incomplete', $this->object->get_display_status() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::set_status
	 */
	public function testSet_status() {
		$this->assertEquals( 0, did_action( 'wpec_transaction_dummy' ) );
		$this->object->set_status( 'dummy' );
		$this->assertEquals( 1, did_action( 'wpec_transaction_dummy' ) );
		// No actions with the same status.
		$this->object->set_status( 'dummy' );
		$this->assertEquals( 1, did_action( 'wpec_transaction_dummy' ) );
	}

	/**
	 * @covers WP_Express_Checkout\Order::set_author
	 */
	public function testSet_author() {
		$this->object->set_author( 42 );
		$this->assertEquals( 42, $this->object->get_author() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::set_author_email
	 */
	public function testSet_author_email() {
		$this->assertEquals( 'dummy.user@example.com', get_post_meta( $this->object->get_id(), 'wpec_order_customer_email', true ) );
		$this->object->set_author_email( 'dummy.user2@example.com' );
		$this->assertEquals( 'dummy.user2@example.com', get_post_meta( $this->object->get_id(), 'wpec_order_customer_email', true ) );
	}

	/**
	 * @covers WP_Express_Checkout\Order::set_author_email
	 */
	public function testSet_author_email__bad_email() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->set_author_email( 'dummy.user.com' );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_author
	 */
	public function testGet_author() {
		$this->assertEquals( get_current_user_id(), $this->object->get_author() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_ip_address
	 */
	public function testGet_ip_address() {
		$this->assertEquals( '42.42.42', $this->object->get_ip_address() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_return_url
	 */
	public function testGet_return_url() {
		$this->assertEquals( Order::get_url( $this->object->get_id() ), $this->object->get_return_url() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_cancel_url
	 */
	public function testGet_cancel_url() {
		$this->assertEquals( add_query_arg( "cancel", 1, $this->object->get_return_url() ), $this->object->get_cancel_url() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_parent
	 */
	public function testGet_parent() {
		$this->assertEquals( $this->post->post_parent, $this->object->get_parent() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_resource_id
	 */
	public function testGet_resource_id() {
		$this->object->set_resource_id( 'dummy' . $this->object->get_id() );
		$this->assertEquals( 'dummy' . $this->object->get_id(), $this->object->get_resource_id() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::set_resource_id
	 */
	public function testSet_resource_id() {
		$this->object->set_resource_id( 'dummy' . $this->object->get_id() );
		$this->assertEquals( 'dummy' . $this->object->get_id(), $this->object->get_resource_id() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::set_resource_id
	 */
	public function testSet_resource_id__bad_id() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		$this->object->set_resource_id( array( 'not-a-string' ) );
	}

	/**
	 * @covers WP_Express_Checkout\Order::add_data
	 */
	public function testAdd_data() {
		$this->object->add_data( 'dummy_data', $this->object->get_id() );
		$this->assertEquals( $this->object->get_id(), $this->object->get_data( 'dummy_data' ) );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_data
	 */
	public function testGet_data() {
		$this->object->add_data( 'dummy_data', $this->object->get_id() );
		$this->assertEquals( $this->object->get_id(), $this->object->get_data( 'dummy_data' ) );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_data
	 */
	public function testGet_data__all() {
		$this->object->add_data( 'dummy_data', $this->object->get_id() );
		$this->assertEquals( [ 'dummy_data' => $this->object->get_id() ], $this->object->get_data() );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_url
	 */
	public function testGet_url() {
		$this->assertEquals( get_permalink( $this->object->get_id() ), Order::get_url( $this->object->get_id() ) );

		add_filter( 'wpec_order_return_url', '__return_zero' );
		$this->assertEquals( 0, Order::get_url( $this->object->get_id() ) );
	}

	/**
	 * @covers WP_Express_Checkout\Order::get_url
	 */
	public function testGet_url__bad_id() {
		$this->expectException( 'PHPUnit_Framework_Error_Warning' );
		Order::get_url( 'not-a-number' );
	}

}
