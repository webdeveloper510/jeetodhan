<?php
declare(strict_types=1);

namespace WPDesk\ShopMagic\Exception;

use LogicException;

final class ResourceNotFound extends LogicException implements ShopMagicException, \Psr\Container\NotFoundExceptionInterface {
}
