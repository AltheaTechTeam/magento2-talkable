<?php
/**
 * Created by PhpStorm.
 * User: alvin
 * Date: 21/12/2017
 * Time: 5:16 PM
 */

namespace AltheaTech\Talkable\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use AltheaTech\Talkable\Helper\Config;

class Index extends Action {

	protected $_configHelper;

	/**
	 * @inheritDoc
	 */
	public function __construct(Config $configHelper, Context $context)
	{
		$this->_configHelper = $configHelper;

		parent::__construct($context);
	}

	/**
	 * @inheritDoc
	 */
	public function execute()
	{
		if (!$this->_configHelper->isInviteEnabled()) {

			$this->_forward('defaultNoRoute');
		}

		$this->_view->loadLayout();
		$this->_view->getLayout()->initMessages();
		$this->_view->renderLayout();
	}

}