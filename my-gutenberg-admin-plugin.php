<?php
/**
 * Plugin Name: My Gutenberg Admin Plugin
 */

// オプションページの追加
function my_plugin_menu() {
	add_options_page(
		'My Gutenberg Admin Plugin', // メニューを選択した時にページのタイトルタグに表示されるテキスト
		'My Gutenberg Admin Plugin', // メニューで表示されるテキスト
		'administrator',             // メニューを使用出来る権限（今回は管理者）
		'my-gutenberg-admin-plugin', // スラッグ名（URLの一部にもなる）
		'my_settings_page'           // コールバック関数
	);
};
add_action( 'admin_menu', 'my_plugin_menu' );

// オプションページのコンテンツ
function my_settings_page() {
	echo '<div id="my-gutenberg-admin-plugin"></div>';
}

function my_admin_scripts( $hook_suffix ) {

	// 作成したオプションページ以外では読み込まない
	if ( 'settings_page_my-gutenberg-admin-plugin' !== $hook_suffix ) {
		return;
	}

	// 依存スクリプト・バージョンが記述されたファイルを読み込み
	$asset_file = include( plugin_dir_path( __FILE__ ) . '/build/index.asset.php' );

	// CSSファイルの読み込み
	wp_enqueue_style(
		'my-gutenberg-admin-plugin-style',
		plugin_dir_url( __FILE__ ) . '/build/index.css',
		array( 'wp-components' ) // ←Gutenbergコンポーネントのデフォルトスタイルを読み込み
	);

	// JavaScriptファイルの読み込み
	wp_enqueue_script(
		'my-gutenberg-admin-plugin-script',
		plugin_dir_url( __FILE__ ) . '/build/index.js',
		$asset_file['dependencies'],
		$asset_file['version'],
		true
	);
}
add_action( 'admin_enqueue_scripts', 'my_admin_scripts' );

// 設定項目の登録
function my_register_settings() {
	// 広告を表示する
	register_setting(
		'my_gutenberg_admin_plugin_settings',
		'my_gutenberg_admin_plugin_show_flg',
		array(
			'type'         => 'boolean',
			'show_in_rest' => true,
			'default'      => true,
		)
	);
	// テキスト
	register_setting(
		'my_gutenberg_admin_plugin_settings',
		'my_gutenberg_admin_plugin_text',
		array(
			'type'         => 'string',
			'show_in_rest' => true,
			'default'      => 'ここにテキストが入ります',
		)
	);
	// 文字サイズ
	register_setting(
		'my_gutenberg_admin_plugin_settings',
		'my_gutenberg_admin_plugin_font_size',
		array(
			'type'         => 'number',
			'show_in_rest' => true,
			'default'      => 16,
		)
	);
}
add_action( 'init', 'my_register_settings' );
