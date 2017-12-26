<?php
/**
 * Created by PhpStorm.
 * User: alvin
 * Date: 26/12/2017
 * Time: 2:13 PM
 */

namespace AltheaTech\Talkable\Block;

use Magento\Checkout\Block\Onepage\Success;

class Purchase extends Success {

	public function getCheckoutOrder()
	{
		return $this->_checkoutSession->getLastRealOrder();
	}

}