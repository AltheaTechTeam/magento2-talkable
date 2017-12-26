<?php
/**
 * Created by PhpStorm.
 * User: alvin
 * Date: 26/12/2017
 * Time: 2:13 PM
 */

namespace AltheaTech\Talkable\Block\Multishipping;

use Magento\Customer\Model\Session;
use Magento\Multishipping\Block\Checkout\Success;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class Purchase extends Success {

	protected $_customerSession;
	protected $_orderCollectionFactory;

	/**
	 * @inheritDoc
	 */
	public function __construct(
		Session $customerSession,
		CollectionFactory $collectionFactory,
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Multishipping\Model\Checkout\Type\Multishipping $multishipping,
		array $data = []
	)
	{
		$this->_customerSession        = $customerSession;
		$this->_orderCollectionFactory = $collectionFactory;

		parent::__construct($context, $multishipping, $data);
	}

	public function getCheckoutOrder()
	{
		return $this->_orderCollectionFactory->create()
		                                     ->addFieldToSelect('*')
		                                     ->addFieldToFilter('customer_id', ['eq' => $this->_customerSession->getCustomerId()])
		                                     ->setOrder('created_at')
		                                     ->getFirstItem();
	}

}