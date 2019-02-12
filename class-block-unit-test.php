<?php
/**
 * Plugin Name: Gutenberg Block Unit Test
 * Plugin URI: https://richtabor.com/gutenberg-block-unit-test/
 * Description: @@pkg.description
 * Author: Rich Tabor
 * Author URI: https://richtabor.com
 * Tags: gutenberg, editor, block, unit test, coblocks
 * Version: 1.0.5
 * Text Domain: '@@pkg.name'
 * Domain Path: languages
 * Tested up to: @@pkg.tested_up_to
 *
 * @@pkg.title is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with @@pkg.title. If not, see <http://www.gnu.org/licenses/>.
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
 * Main @@pkg.title Class
 *
 * @since 1.0.0
 */
class Block_Unit_Test {

	/**
	 * The plugin instance.
	 *
	 * @var Block_Unit_Test
	 */
	private static $instance;

	/**
	 * Registers the plugin.
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new Block_Unit_Test();
			self::$instance->includes();
		}
	}

	/**
	 * The plugin version.
	 *
	 * @var string $_version
	 */
	private $_version;

	/**
	 * The base URL path.
	 *
	 * @var string $_url
	 */
	private $_url;

	/**
	 * The Constructor.
	 */
	private function __construct() {

		$this->_version = '@@pkg.version';
		$this->_url     = untrailingslashit( plugins_url( '/assets/images', __FILE__ ) );

		// Actions.
		add_action( 'upgrader_process_complete', array( $this, 'upgrade_completed' ), 10, 2 );
		// add_action( 'plugins_loaded', array( $this, 'suggest_coblocks' ) );

		// Filters.
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @since 1.0.3
	 * @return void
	 */
	private function includes() {

		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		require_once untrailingslashit( plugin_dir_path( '/', __FILE__ ) ) . 'includes/class-block-unit-test-standart.php';

		// Check for woo-gutenberg-products-block.
		if ( is_plugin_active( 'woo-gutenberg-products-block/woocommerce-gutenberg-products-block.php' ) ) {
			require_once untrailingslashit( plugin_dir_path( '/', __FILE__ ) ) . 'includes/class-block-unit-test-wooblocks.php';
		}
		
		// Check for CoBlocks.
		if ( is_plugin_active( 'coblocks/class-coblocks.php' ) ) {
			require_once untrailingslashit( plugin_dir_path( '/', __FILE__ ) ) . 'includes/class-block-unit-test-coblocks.php';
		}

		// Check for atomBlocks.
		if ( is_plugin_active( 'atomic-blocks/atomicblocks.php' ) ) {
			require_once untrailingslashit( plugin_dir_path( '/', __FILE__ ) ) . 'includes/class-block-unit-test-atomblocks.php';
		}

		// Includes.
		require_once untrailingslashit( plugin_dir_path( '/', __FILE__ ) ) . 'includes/class-block-unit-test-suggest-coblocks.php';
		require_once untrailingslashit( plugin_dir_path( '/', __FILE__ ) ) . 'includes/vendors/dismiss-notices/dismiss-notices.php';
	}

	/**
	 * Reccommend CoBlocks, if the plugin is not installed.
	 *
	 * @access public
	 * @since 1.0.3
	 * @return void
	 */
	public function suggest_coblocks() {

		// Check for CoBlocks and suggest it if it's not installed.
		if ( ! class_exists( 'CoBlocks' ) ) {
			$suggestion = new Block_Unit_Test_Suggest_CoBlocks( plugin_dir_path( __FILE__ ) );
			$suggestion = $suggestion->run();
		}
	}

	/**
	 * Plugin row meta links
	 *
	 * @param array|array   $input already defined meta links.
	 * @param string|string $file plugin file path and name being processed.
	 * @return array $input
	 */
	public function plugin_row_meta( $input, $file ) {

		if ( 'block-unit-test/class-block-unit-test.php' !== $file ) {
			return $input;
		}

		$url = 'https://richtabor.com/gutenberg-block-unit-test/';

		$links = array(
			'<a href="' . esc_url( $url ) . '" target="_blank">' . esc_html__( 'More information', '@@textdomain' ) . '</a>',
		);

		$input = array_merge( $input, $links );

		return $input;
	}
}
Block_Unit_Test::register();
