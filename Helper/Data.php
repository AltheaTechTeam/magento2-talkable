<?php
/**
 * Created by PhpStorm.
 * User: alvin
 * Date: 21/12/2017
 * Time: 12:18 PM
 */

namespace AltheaTech\Talkable\Helper;

use Magento\Customer\Model\Session;
use Magento\Directory\Model\CountryFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Sales\Model\Order;

class Data extends AbstractHelper {

	protected $_countryFactory;
	protected $_customerSession;

	/**
	 * @inheritDoc
	 */
	public function __construct(
		CountryFactory $countryFactory,
		Session $customerSession,
		Context $context
	)
	{
		$this->_countryFactory  = $countryFactory;
		$this->_customerSession = $customerSession;

		parent::__construct($context);
	}

	public function getPurchaseData(Order $order)
	{
		$shippingInfo    = [];
		$shippingAddress = $order->getShippingAddress();

		if ($shippingAddress) {

			$countryName    = $this->_countryFactory->create()
			                                        ->loadByCode($shippingAddress->getCountryId())
			                                        ->getName();
			$shippingFields = array_filter([
				implode(", ", $shippingAddress->getStreet()),
				$shippingAddress->getCity(),
				$shippingAddress->getRegion(),
				$shippingAddress->getPostcode(),
				$countryName,
			]);
			$shippingInfo   = [
				"shipping_zip"     => $shippingAddress->getPostcode(),
				"shipping_address" => implode(", ", $shippingFields),
			];
		}

		$subtotal = (float)$order->getSubtotal();

		if ($order->getDiscountAmount() < 0) {

			// getDiscountAmount() returns negative number formatted as string, e.g. "-10.0000"
			// That's why we add it instead of subtracting.
			$subtotal += (float)$order->getDiscountAmount();
		}

		$retval = [
			"customer" => [
				"email"       => $order->getCustomerEmail(),
				"first_name"  => $order->getCustomerFirstname(),
				"last_name"   => $order->getCustomerLastname(),
				"customer_id" => $order->getCustomerId(),
			],
			"purchase" => array_merge($shippingInfo, [
				"order_number" => $order->getIncrementId(),
				"order_date"   => $order->getCreatedAt(),
				"subtotal"     => $this->_normalizeAmount($subtotal),
				"coupon_code"  => $order->getCouponCode(),
				"items"        => [],
			]),
		];

		/* @var Order\Item $product */
		foreach ($order->getAllVisibleItems() as $product) {

			$retval["purchase"]["items"][] = [
				"product_id" => $product->getSku(),
				"price"      => $this->_normalizeAmount($product->getPrice()),
				"quantity"   => strval(round($product->getQtyOrdered())),
				"title"      => $product->getName(),
			];
		}

		return $retval;
	}

	public function getCustomerData()
	{
		if ($this->_customerSession->isLoggedIn()) {

			$customer  = $this->_customerSession->getCustomer();
			$dataModel = $customer->getDataModel();

			return [
				"email"       => $dataModel->getEmail(),
				"first_name"  => $dataModel->getFirstname(),
				"last_name"   => $dataModel->getLastname(),
				"customer_id" => $customer->getEntityId(),
			];
		} else {

			return new \stdClass();
		}
	}

	protected function _normalizeAmount($value)
	{
		return number_format((float)$value, 2, ".", "");
	}

}