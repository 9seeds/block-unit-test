<?php
/**
 * Unit testing for WooBlocks, if the plugin is activated.
 *
 * @package   @@pkg.title
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Block_Unit_Test_WooBlocks Class
 *
 * @since 1.0.3
 */
class Block_Unit_Test_WooBlocks {

	/**
	 * The class instance.
	 *
	 * @var Block_Unit_Test_WooBlocks
	 */
	private static $instance;

	/**
	 * Registers the class.
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new Block_Unit_Test_WooBlocks();
		}
	}

	/**
	 * The Constructor.
	 */
	private function __construct() {
		add_action( 'admin_init', array( $this, 'create_wooblocks_unit_test_page' ) );
		add_action( 'admin_init', array( $this, 'update_wooblocks_unit_test_page' ) );
	}

	/**
	 * Creates a page for the WooBlocks to be rendered on.
	 */
	public function create_wooblocks_unit_test_page() {

		$title = apply_filters( 'block_unit_test_wooblocks_title', 'Woocommerce Blocks Unit Test ' );

		// Do not create the post if it's already present.
		if ( post_exists( $title ) ) {
			return;
		}

		// Create the Block Unit Test page.
		wp_insert_post(
			array(
				'post_title'     => $title,
				'post_content'   => $this->wooblocks_content(),
				'post_status'    => 'draft',
				'post_author'    => 1,
				'post_type'      => 'page',
				'comment_status' => 'closed',
			)
		);
	}

	/**
	 * Updates the WooBlocks page upon plugin updates.
	 */
	public function update_wooblocks_unit_test_page() {

		$title = apply_filters( 'block_unit_test_wooblocks_title', 'Woocommerce Blocks Unit Test ' );
		$post  = get_page_by_title( $title, OBJECT, 'page' );

		// Return if the page does not exist.
		if ( ! post_exists( $title ) ) {
			return;
		}

		// Return if the update transient does not exist.
		if ( ! get_transient( 'block_unit_test_updated' ) ) {
			return;
		}

		// Update the post with the latest content update.
		wp_update_post(
			array(
				'ID'           => $post->ID,
				'post_content' => $this->wooblocks_content(),
			)
		);

		// Delete the transient.
		delete_transient( 'block_unit_test_updated' );
	}

	/**
	 * Content for the test page.
	 */
	public function wooblocks_content() {

		// Retrieve the asset URLs.
		$url = untrailingslashit( plugins_url( '/assets/images', dirname( __FILE__ ) ) );

		$content = '';

		$content .= '
		<!-- wp:heading {"level":3} -->
		<h3>Handpicked products</h3>
		<!-- /wp:heading -->
		
		<!-- wp:woocommerce/handpicked-products {"columns":5,"editMode":false,"products":[468,466,464,462,460,453,438,429]} -->
		<div class="wp-block-woocommerce-handpicked-products">[products limit="8" columns="5" orderby="date" order="DESC" ids="468,466,464,462,460,453,438,429"]</div>
		<!-- /wp:woocommerce/handpicked-products -->
		
		<!-- wp:separator -->
		<hr class="wp-block-separator"/>
		<!-- /wp:separator -->
		
		<!-- wp:heading {"level":3} -->
		<h3>Best selling products</h3>
		<!-- /wp:heading -->
		
		<!-- wp:woocommerce/product-best-sellers -->
		<div class="wp-block-woocommerce-product-best-sellers">[products limit="12" columns="3" best_selling="1"]</div>
		<!-- /wp:woocommerce/product-best-sellers -->
		
		<!-- wp:separator -->
		<hr class="wp-block-separator"/>
		<!-- /wp:separator -->
		
		<!-- wp:heading {"level":3} -->
		<h3>Newest Products</h3>
		<!-- /wp:heading -->
		
		<!-- wp:woocommerce/product-new -->
		<div class="wp-block-woocommerce-product-new">[products limit="12" columns="3" orderby="date" order="DESC"]</div>
		<!-- /wp:woocommerce/product-new -->
		
		<!-- wp:separator -->
		<hr class="wp-block-separator"/>
		<!-- /wp:separator -->
		
		<!-- wp:heading {"level":3} -->
		<h3>Products by category</h3>
		<!-- /wp:heading -->
		
		<!-- wp:woocommerce/product-category {"categories":[28,26],"editMode":false} -->
		<div class="wp-block-woocommerce-product-category">[products limit="12" columns="3" category="28,26" orderby="date" order="DESC"]</div>
		<!-- /wp:woocommerce/product-category -->
		
		<!-- wp:separator -->
		<hr class="wp-block-separator"/>
		<!-- /wp:separator -->
		
		<!-- wp:heading {"level":3} -->
		<h3>On sale Products</h3>
		<!-- /wp:heading -->
		
		<!-- wp:woocommerce/product-on-sale -->
		<div class="wp-block-woocommerce-product-on-sale">[products limit="12" columns="3" orderby="date" order="DESC" on_sale="1"]</div>
		<!-- /wp:woocommerce/product-on-sale -->
		
		<!-- wp:separator -->
		<hr class="wp-block-separator"/>
		<!-- /wp:separator -->
		
		<!-- wp:heading {"level":3} -->
		<h3>Top rated product</h3>
		<!-- /wp:heading -->
		
		<!-- wp:woocommerce/product-top-rated -->
		<div class="wp-block-woocommerce-product-top-rated">[products limit="12" columns="3" orderby="rating"]</div>
		<!-- /wp:woocommerce/product-top-rated -->
		
		<!-- wp:separator -->
		<hr class="wp-block-separator"/>
		<!-- /wp:separator -->
		
		<!-- wp:heading {"level":3} -->
		<h3>Featured Product</h3>
		<!-- /wp:heading -->
		
		<!-- wp:woocommerce/featured-product {"editMode":false,"productId":466} /-->
		
		<!-- wp:paragraph -->
		<p></p>
		<!-- /wp:paragraph -->
		
		<!-- wp:paragraph -->
		<p></p>
		<!-- /wp:paragraph -->
			';
		return apply_filters( 'block_unit_test_wooblocks_content', $content );
	}
}
Block_Unit_Test_WooBlocks::register();
