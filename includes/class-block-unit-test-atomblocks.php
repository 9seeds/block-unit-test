<?php
/**
 * Unit testing for AtomBlocks, if the plugin is activated.
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
 * Main Block_Unit_Test_AtomBlocks Class
 *
 * @since 1.0.3
 */
class Block_Unit_Test_AtomBlocks {

	/**
	 * The class instance.
	 *
	 * @var Block_Unit_Test_AtomBlocks
	 */
	private static $instance;

	/**
	 * The base URL path.
	 *
	 * @var string $_url
	 */
	private $_url;

	/**
	 * Registers the class.
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new Block_Unit_Test_AtomBlocks();
		}
	}

	/**
	 * The Constructor.
	 */
	private function __construct() {
		add_action( 'admin_init', array( $this, 'create_atomblocks_unit_test_page' ) );
		add_action( 'admin_init', array( $this, 'update_atomblocks_unit_test_page' ) );
	}

	/**
	 * Creates a page for the AtomBlocks to be rendered on.
	 */
	public function create_atomblocks_unit_test_page() {

		$title = apply_filters( 'block_unit_test_atomblocks_title', 'Atom Blocks Unit Test ' );

		// Do not create the post if it's already present.
		if ( post_exists( $title ) ) {
			return;
		}

		// Create the Block Unit Test page.
		wp_insert_post(
			array(
				'post_title'     => $title,
				'post_content'   => $this->atomblocks_content(),
				'post_status'    => 'draft',
				'post_author'    => 1,
				'post_type'      => 'page',
				'comment_status' => 'closed',
			)
		);
	}

	/**
	 * Updates the AtomBlocks page upon plugin updates.
	 */
	public function update_atomblocks_unit_test_page() {

		$title = apply_filters( 'block_unit_test_atomblocks_title', 'Atom Blocks Unit Test ' );
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
				'post_content' => $this->atomblocks_content(),
			)
		);

		// Delete the transient.
		delete_transient( 'block_unit_test_updated' );
	}

	/**
	 * Content for the test page.
	 */
	public function atomblocks_content() {

		// Retrieve the asset URLs.
		$this->_url =  plugins_url( '../assets/images',__FILE__) ;

		$content = '';

		$content .= '
		<!-- wp:atomic-blocks/ab-testimonial -->
		<div style="background-color:#f2f2f2;color:#32373c" class="wp-block-atomic-blocks-ab-testimonial left-aligned ab-font-size-18 ab-block-testimonial"><div class="ab-testimonial-text"><p>Rapidiously leverage existing market positioning models without focused products.</p></div><div class="ab-testimonial-info"><h2 class="ab-testimonial-name" style="color:#32373c">Holisticly</h2><small class="ab-testimonial-title" style="color:#32373c">Professionally promote</small></div></div>
		<!-- /wp:atomic-blocks/ab-testimonial -->

		<!-- wp:atomic-blocks/ab-profile-box {"profileImgID":79} -->
		<div style="background-color:#f2f2f2;color:#32373c" class="wp-block-atomic-blocks-ab-profile-box square ab-has-avatar ab-font-size-18 ab-block-profile ab-profile-columns"><div class="ab-profile-column ab-profile-avatar-wrap"><div class="ab-profile-image-wrap"><div class="ab-profile-image-square"><img class="ab-profile-avatar" src="'.esc_url( $this->_url . '/placeholder.jpg' ) .'" alt="avatar"/></div></div></div><div class="ab-profile-column ab-profile-content-wrap"><h2 class="ab-profile-name" style="color:#32373c">out-of-the-box</h2><p class="ab-profile-title" style="color:#32373c">manufactured products</p><div class="ab-profile-text"><p>Assertively orchestrate covalent interfaces with one-to-one processes.</p></div><ul class="ab-social-links"></ul></div></div>
		<!-- /wp:atomic-blocks/ab-profile-box -->

		<!-- wp:atomic-blocks/ab-notice {"noticeTitle":"Competently"} -->
		<div style="color:#32373c;background-color:#00d1b2" class="wp-block-atomic-blocks-ab-notice ab-font-size-18 ab-block-notice" data-id="a3f5e3"><div class="ab-notice-title" style="color:#fff"><p>Competently</p></div><div class="ab-notice-text" style="border-color:#00d1b2"><p>Credibly harness alternative leadership skills rather than cross-unit best practices.</p></div></div>
		<!-- /wp:atomic-blocks/ab-notice -->

		<!-- wp:atomic-blocks/ab-drop-cap -->
		<div style="color:#32373c" class="wp-block-atomic-blocks-ab-drop-cap drop-cap-letter ab-font-size-3 ab-block-drop-cap"><div class="ab-drop-cap-text"><p>Assertively exploit market positioning expertise via client-centric benefits. Objectively productivate standardized materials after enabled innovation.</p></div></div>
		<!-- /wp:atomic-blocks/ab-drop-cap -->

		<!-- wp:atomic-blocks/ab-button {"buttonText":"Seamlessly"} -->
		<div class="wp-block-atomic-blocks-ab-button ab-block-button"><a href="http://google.com" class="ab-button ab-button-shape-rounded ab-button-size-medium" style="color:#ffffff;background-color:#3373dc">Seamlessly</a></div>
		<!-- /wp:atomic-blocks/ab-button -->

		<!-- wp:atomic-blocks/ab-spacer {"spacerHeight":133} -->
		<div style="color:#ddd" class="wp-block-atomic-blocks-ab-spacer ab-block-spacer ab-divider-solid ab-divider-size-1"><hr style="height:133px"/></div>
		<!-- /wp:atomic-blocks/ab-spacer -->

		<!-- wp:atomic-blocks/ab-accordion -->
		<div class="wp-block-atomic-blocks-ab-accordion ab-block-accordion ab-font-size-18"><details><summary class="ab-accordion-title">Credibly leverage </summary><div class="ab-accordion-text"><!-- wp:paragraph -->
		<p>Collaboratively harness alternative customer service whereas functional synergy. Dramatically architect cross functional schemas through open-source action items</p>
		<!-- /wp:paragraph --></div></details></div>
		<!-- /wp:atomic-blocks/ab-accordion -->

		<!-- wp:atomic-blocks/ab-cta {"buttonText":"seize"} -->
		<div style="text-align:center" class="wp-block-atomic-blocks-ab-cta ab-block-cta"><div class="ab-cta-content"><h2 class="ab-cta-title ab-font-size-32" style="color:#32373c">Rapidiously envisioneer corporate</h2><div class="ab-cta-text ab-font-size-32" style="color:#32373c"><p>unleash</p></div></div><div class="ab-cta-button"><a href="http://google.com" target="_self" class="ab-button ab-button-shape-rounded ab-button-size-medium" style="color:#ffffff;background-color:#3373dc">seize</a></div></div>
		<!-- /wp:atomic-blocks/ab-cta -->

		<!-- wp:atomic-blocks/ab-sharing /-->

		<!-- wp:atomic-blocks/ab-post-grid /-->

		<!-- wp:atomic-blocks/ab-container -->
		<div style="background-color:#fff;padding-left:0%;padding-right:0%;padding-bottom:0%;padding-top:0%;margin-top:0%;margin-bottom:0%" class="wp-block-atomic-blocks-ab-container aligncenter ab-block-container"><div class="ab-container-inside"><div class="ab-container-content" style="max-width:1600px"><!-- wp:atomic-blocks/ab-button {"buttonText":"procedures"} -->
		<div class="wp-block-atomic-blocks-ab-button ab-block-button"><a href="http://google.com" class="ab-button ab-button-shape-rounded ab-button-size-medium" style="color:#ffffff;background-color:#3373dc">procedures</a></div>
		<!-- /wp:atomic-blocks/ab-button --></div></div></div>
		<!-- /wp:atomic-blocks/ab-container -->
			';
		return apply_filters( 'block_unit_test_atomblocks_content', $content );
	}
}
Block_Unit_Test_AtomBlocks::register();
