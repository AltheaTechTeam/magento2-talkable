<?php
/**
 * Created by PhpStorm.
 * User: alvin
 * Date: 22/12/2017
 * Time: 11:14 AM
 */

namespace AltheaTech\Talkable\Controller\Dashboard;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use AltheaTech\Talkable\Helper\Config;

class Index extends Action {

	protected $_configHelper;

	/**
	 * @inheritDoc
	 */
	public function __construct(Config $config, Context $context)
	{
		$this->_configHelper = $config;

		parent::__construct($context);
	}

	/**
	 * @inheritDoc
	 */
	public function execute()
	{
		if (!$this->_configHelper->isAdvocateDashboardEnabled()) {

			$this->_forward('defaultNoRoute');
		}

		$this->_view->loadLayout();
		$this->_view->getLayout()->initMessages();
		$this->_view->renderLayout();
	}

}