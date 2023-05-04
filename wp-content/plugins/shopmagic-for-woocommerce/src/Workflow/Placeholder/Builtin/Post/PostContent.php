<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Placeholder\Builtin\Post;

use WPDesk\ShopMagic\Workflow\Placeholder\Builtin\PostBasedPlaceholder;

final class PostContent extends PostBasedPlaceholder {

	public function get_slug(): string {
		return 'content';
	}

	public function get_description(): string {
		return '';
	}

	public function value( array $parameters ): string {
		// TODO: Wrap in WP functions to enable content formatting and shortcodes
		return $this->get_post()->post_content;
	}
}
