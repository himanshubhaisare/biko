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

        if ($this->request->isPost()) {

            if (!$this->session->has('sessionId')) {
                $sessionId = md5(uniqid("sess", true));
                $this->session->set('sessionId', $sessionId);
            } else {
                $sessionId = $this->session->get('sessionId');
            }

            /** Add/Update shopping cart */
            $cart = Cart::findFirst(array(
                array(
                    'sessionId'  => $sessionId,
                    'productsId' => $product->id
                )
            ));
            if (!$cart) {
                $cart = new Cart();
                $cart->sessionId  = $sessionId;
                $cart->productsId = $product->id;
                $cart->quantity   = 1;
            } else {
                $cart->quantity++;
            }

            $cart->save();

        }

        $this->view->product = $product;
    }


}

