/**
 * ブロックエディタ用: アイキャッチ未設定時に警告パネルを表示する
 */

import { registerPlugin } from '@wordpress/plugins';
import { PluginPrePublishPanel, PluginPostStatusInfo } from '@wordpress/edit-post';
import { useSelect } from '@wordpress/data';
import { store as editorStore } from '@wordpress/editor';
import { __ } from '@wordpress/i18n';
import { Warning } from '@wordpress/components';

const FeaturedImageWarning = () => {
	const hasFeaturedImage = useSelect( ( select ) => {
		const featuredImageId = select( editorStore ).getEditedPostAttribute( 'featured_media' );
		return !! featuredImageId;
	} );

	if ( hasFeaturedImage ) {
		return null;
	}

	return (
		<>
			{ /* 公開前パネル内の警告 */ }
			<PluginPrePublishPanel
				title={ __( 'アイキャッチ画像', 'featured-image-warning' ) }
				initialOpen={ true }
				icon="format-image"
			>
				<Warning>
					{ __( 'アイキャッチ画像が設定されていません。公開前に設定することを推奨します。', 'featured-image-warning' ) }
				</Warning>
			</PluginPrePublishPanel>

			{ /* サイドバーの投稿ステータス欄に常時表示 */ }
			<PluginPostStatusInfo>
				<div className="fiw-sidebar-warning">
					<span className="dashicons dashicons-warning" aria-hidden="true"></span>
					{ __( 'アイキャッチ画像が未設定です', 'featured-image-warning' ) }
				</div>
			</PluginPostStatusInfo>
		</>
	);
};

registerPlugin( 'featured-image-warning', {
	render: FeaturedImageWarning,
} );
