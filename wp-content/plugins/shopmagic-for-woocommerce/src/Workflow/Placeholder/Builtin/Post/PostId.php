<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Placeholder\Builtin\Post;

use WPDesk\ShopMagic\Workflow\Placeholder\Builtin\PostBasedPlaceholder;

final class PostId extends PostBasedPlaceholder {

	public function get_slug(): string {
		return 'id';
	}

	public function get_description(): string {
		return '';
	}

	public function value( array $parameters ): string {
		return (string) $this->get_post()->ID;
	}
}
