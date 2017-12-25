<?php
/**
 * Created by PhpStorm.
 * User: alvin
 * Date: 21/12/2017
 * Time: 12:02 PM
 */

namespace AltheaTech\Talkable\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper {

	const XML_PATH_GENERAL_SITE_ID                 = 'socialreferrals/general/site_id';
	const XML_PATH_CAMPAIGNS_POST_PURCHASE         = 'socialreferrals/campaigns/post_purchase';
	const XML_PATH_CAMPAIGNS_INVITE                = 'socialreferrals/campaigns/invite';
	const XML_PATH_CAMPAIGNS_ADVOCATE_DASHBOARD    = 'socialreferrals/campaigns/advocate_dashboard';
	const XML_PATH_CAMPAIGNS_FLOATING_WIDGET_POPUP = 'socialreferrals/campaigns/floating_widget_popup';

	public function getSiteId($storeId = null)
	{
		return $this->scopeConfig->getValue(self::XML_PATH_GENERAL_SITE_ID, ScopeInterface::SCOPE_STORES, $storeId);
	}

	public function isPostPurchaseEnabled($storeId = null)
	{
		return (bool)$this->scopeConfig->getValue(self::XML_PATH_CAMPAIGNS_POST_PURCHASE, ScopeInterface::SCOPE_STORES, $storeId);
	}

	public function isInviteEnabled($storeId = null)
	{
		return (bool)$this->scopeConfig->getValue(self::XML_PATH_CAMPAIGNS_INVITE, ScopeInterface::SCOPE_STORES, $storeId);
	}

	public function isAdvocateDashboardEnabled($storeId = null)
	{
		return (bool)$this->scopeConfig->getValue(self::XML_PATH_CAMPAIGNS_ADVOCATE_DASHBOARD, ScopeInterface::SCOPE_STORES, $storeId);
	}

	public function isFloatingWidgetPopupEnabled($storeId = null)
	{
		return (bool)$this->scopeConfig->getValue(self::XML_PATH_CAMPAIGNS_FLOATING_WIDGET_POPUP, ScopeInterface::SCOPE_STORES, $storeId);
	}

}