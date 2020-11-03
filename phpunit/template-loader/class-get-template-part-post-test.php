<?php
/**
 * Full Site Editing: Template part tests.
 *
 * @package Gutenberg
 */

/**
 * Tests for the `gutenberg_get_template_part_post` function.
 */
class Get_Template_Part_Post_Test extends WP_UnitTestCase {
	/**
	 * @var int First index template part post.
	 */
	public static $index_1;

	/**
	 * @var int Second index template part post.
	 */
	public static $index_2;

	/**
	 * @var int Footer template part post.
	 */
	public static $footer;

	/**
	 * Create shared fixtures.
	 */
	public static function wpSetupBeforeClass() {
		self::$index_1 = self::factory()->post->create(
			array(
				'post_type'   => 'wp_template_part',
				'post_status' => 'publish',
				'post_name'   => 'index',
			)
		);

		self::$index_2 = self::factory()->post->create(
			array(
				'post_type'   => 'wp_template_part',
				'post_status' => 'publish',
				'post_name'   => 'index',
			)
		);

		self::$footer = self::factory()->post->create(
			array(
				'post_type'   => 'wp_template_part',
				'post_status' => 'publish',
				'post_name'   => 'footer',
			)
		);
	}


	/**
	 * Verify that retrieving a template part takes into account the theme slug.
	 */
	public function test_template_parts_are_per_theme() {
		add_post_meta( self::$index_1, 'theme', 'foo' );
		add_post_meta( self::$index_2, 'theme', 'bar' );

		$template_part_post = gutenberg_get_template_part_post( 'index', 'foo' );

		$this->assertSame( self::$index_1, $template_part_post->ID );
	}

	/**
	 * Verify that retrieving a template part takes into account the template part slug.
	 */
	public function test_template_parts_are_per_slug() {
		add_post_meta( self::$index_1, 'theme', 'foo' );
		add_post_meta( self::$footer, 'theme', 'foo' );

		$template_part_post = gutenberg_get_template_part_post( 'footer', 'foo' );

		$this->assertSame( self::$footer, $template_part_post->ID );
	}

	/**
	 * Verify that an error is emitted when two template part posts exist for the same template and theme slug.
	 */
	public function test_duplicate_template_parts() {
		add_post_meta( self::$index_1, 'theme', 'foo' );
		add_post_meta( self::$index_2, 'theme', 'foo' );

		$template_part_post = gutenberg_get_template_part_post( 'index', 'foo' );

		$this->assertWPError( $template_part_post );
		$this->assertSame( 'fse-duplicate-template-part', $template_part_post->get_error_code() );
	}

	/**
	 * Verify that `null` is returned if no template part post exists.
	 */
	public function test_no_template_part() {
		$template_part_post = gutenberg_get_template_part_post( 'footer', 'foo' );

		$this->assertNull( $template_part_post );
	}
}
