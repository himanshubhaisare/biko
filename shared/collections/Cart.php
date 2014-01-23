<?php

namespace Biko\Collections;

use Phalcon\Mvc\Collection;

class Cart extends Collection
{
	public $sessionId;

	public $productsId;

	public $quantity;

}