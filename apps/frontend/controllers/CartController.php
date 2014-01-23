<?php

namespace Biko\Frontend\Controllers;

use Biko\Models\Categories;
use Biko\Models\Products;
use Biko\Collections\Cart;
use Biko\Controllers\ControllerBase;

/**
 * @Public
 */
class CartController extends ControllerBase
{

	/**
	 * @Route("/cart/add/{product-id:[0-9]+}", name="add-cart", methods={"POST", "GET"})
	 */
	public function addAction($productId=null)
	{

		/* Check if the product does exist */
		$product = Products::findFirstById($productId);
		if (!$product) {
			$this->flash->error('Product could not be found');
			return $this->dispatcher->forward(array(
				'controller' => 'catalogs',
				'action'     => 'category',
				'params'     => array('software')
			));
		}

		/* Check if the product does exist */
		if (!$product->stock) {
			$this->flash->error('Product cannot be sold because it doesn\'t have stock available');
			return $this->dispatcher->forward(array(
				'controller' => 'catalogs',
				'action'     => 'category',
				'params'     => array('software')
			));
		}

		$uniqueId = $this->unique->get();

		/** Add/Update shopping cart */
		$cart = Cart::findFirst(array(
			array(
				'sessionId'  => $uniqueId,
				'productsId' => $product->id
			)
		));

		$this->view->cart    = $cart;
		$this->view->product = $product;

		if ($this->request->isPost()) {

			$quantity = $this->request->getPost('quantity', 'int', 0);
			if ($quantity <= 0) {
				$this->flash->error('Quantity must be greater than zero');
				return;
			}

			if (!$cart) {
				$cart = new Cart();
				$cart->sessionId  = $uniqueId;
				$cart->productsId = $product->id;
				$cart->quantity   = $quantity;
			} else {
				$cart->quantity += $quantity;
			}

			if ($cart->quantity >= $product->stock) {
				$this->flash->error('We don\'t have enought units to supply the amount you are requesting');
				return;
			}

			if ($cart->save()) {

				$quantityTotal = 0;
				$items = Cart::find(array(
					array('sessionId'  => $uniqueId)
				));
				foreach ($items as $item) {
					$quantityTotal += $item->quantity;
				}

				/** Update how many items are in the cart */
				$this->session->set('cartItems', $quantityTotal);

				if ($quantity > 1) {
					$this->flash->success($quantity . ' copies of "' . $product->name . '" were added to your shopping cart');
				} else {
					$this->flash->success('One copy of "' . $product->name . '" was added to your shopping cart');
				}

				return $this->dispatcher->forward(array(
					'controller' => 'catalogs',
					'action'     => 'category',
					'params'     => array('software')
				));
			}

		}

	}

}

