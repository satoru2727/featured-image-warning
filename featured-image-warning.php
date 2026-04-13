<?php
/**
 * Plugin Name: Featured Image Warning
 * Description: アイキャッチ画像が設定されていない場合に編集画面で警告を表示します。
 * Version: 1.0.0
 * Author: satoru
 * License: GPL-2.0-or-later
 * Text Domain: featured-image-warning
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FIW_VERSION', '1.0.0' );
define( 'FIW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'FIW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * クラシックエディタ用: 管理画面通知を表示
 */
function fiw_admin_notices() {
	$screen = get_current_screen();

	// 投稿編集画面以外は無視
	if ( ! $screen || 'post' !== $screen->base ) {
		return;
	}

	// アイキャッチをサポートしない投稿タイプは無視
	if ( ! post_type_supports( $screen->post_type, 'thumbnail' ) ) {
		return;
	}

	// Gutenberg が有効な場合はスキップ（JS 側で処理）
	if ( $screen->is_block_editor() ) {
		return;
	}

	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return;
	}

	$thumbnail_id = get_post_thumbnail_id( $post_id );
	if ( $thumbnail_id ) {
		return;
	}

	?>
	<div class="notice notice-warning fiw-notice">
		<p>
			<strong><?php esc_html_e( 'アイキャッチ画像が設定されていません。', 'featured-image-warning' ); ?></strong>
			<?php esc_html_e( '公開前にアイキャッチ画像を設定することを推奨します。', 'featured-image-warning' ); ?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'fiw_admin_notices' );

/**
 * ブロックエディタ用: REST API でアイキャッチ状態を返すエンドポイント
 * (JS 側から叩く用。実際の判定は JS 内の store で行うが、
 *  wp.data で直接取得できるので追加エンドポイントは不要)
 */

/**
 * ブロックエディタ用スクリプトを登録・エンキュー
 */
function fiw_enqueue_block_editor_assets() {
	$screen = get_current_screen();
	if ( ! $screen || ! $screen->is_block_editor() ) {
		return;
	}

	if ( ! post_type_supports( $screen->post_type, 'thumbnail' ) ) {
		return;
	}

	$asset_file = FIW_PLUGIN_DIR . 'build/index.asset.php';
	if ( file_exists( $asset_file ) ) {
		$asset = require $asset_file;
	} else {
		$asset = array(
			'dependencies' => array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-i18n', 'wp-notices' ),
			'version'      => FIW_VERSION,
		);
	}

	wp_enqueue_script(
		'fiw-block-editor',
		FIW_PLUGIN_URL . 'build/index.js',
		$asset['dependencies'],
		$asset['version'],
		true
	);

	wp_set_script_translations( 'fiw-block-editor', 'featured-image-warning' );
}
add_action( 'enqueue_block_editor_assets', 'fiw_enqueue_block_editor_assets' );
