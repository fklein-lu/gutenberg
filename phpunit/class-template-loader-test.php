<?php

/**
 * Test block context.
 *
 * @package Gutenberg
 */

class Template_Loader_Test extends WP_UnitTestCase {
	//public static wpSetupBeforeClass

	/*
	function setUp() {
		parent::setUp();
		$this->theme_root = DIR_TESTDATA . '/themedir1';

		$this->orig_theme_dir = $GLOBALS['wp_theme_directories'];

		// /themes is necessary as theme.php functions assume /themes is the root if there is only one root.
		$GLOBALS['wp_theme_directories'] = array( WP_CONTENT_DIR . '/themes', $this->theme_root );

		add_filter( 'theme_root', array( $this, '_theme_root' ) );
		add_filter( 'stylesheet_root', array( $this, '_theme_root' ) );
		add_filter( 'template_root', array( $this, '_theme_root' ) );
		// Clear caches.
		wp_clean_themes_cache();
		unset( $GLOBALS['wp_themes'] );
	}

	// Replace the normal theme root directory with our premade test directory.
	public function filter_theme_root( $dir ) {
		return $this->theme_root;
	}
	*/

	public function test_classic_theme() {
		delete_site_transient( 'theme_roots' );
		$this->assertFalse( gutenberg_is_fse_theme( 'classic-theme' ) );
	}

	public function test_block_based_theme() {
		delete_site_transient( 'theme_roots' );
		var_dump( get_site_transient( 'theme_roots' ) );
		var_dump( get_theme_roots() );

		$this->assertTrue( gutenberg_is_fse_theme( 'block-based-theme' ) );
	}

}
