<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Filter;

use WPDesk\ShopMagic\Workflow\Components\MatchableCollection;
use WPDesk\ShopMagic\Workflow\Components\Sortable;


/**
 * @extends \WPDesk\ShopMagic\Workflow\Components\MatchableCollection<Filter>
 */
final class FiltersList extends MatchableCollection implements Sortable {

	/** @var string */
	protected $type = Filter::class;

	public function offsetGet( $offset ): object {
		if ( $this->offsetExists( $offset ) ) {
			return clone apply_filters( 'shopmagic/core/single_filter', parent::offsetGet( $offset ) );
		}

		return new NullFilter();
	}

	/**
	 * @param Filter $a
	 * @param Filter $b
	 */
	public function compare( object $a, object $b ): int {
		$group_compare = strcmp( $a->get_group_slug(), $b->get_group_slug() );
		if ( $group_compare === 0 ) {
			return strcmp( $a->get_name(), $b->get_name() );
		}

		return $group_compare;
	}

}
