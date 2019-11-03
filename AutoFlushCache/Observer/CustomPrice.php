<?php
namespace Biren\AutoFlushCache\Observer;

use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Checkout\Model\Session as CheckoutSession;

class CustomPrice implements ObserverInterface
{

    protected $checkoutSession;

    protected $quoteRepository;
    protected $shippingRate;

    public function __construct(
        CheckoutSession $checkoutSession,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Quote\Model\Quote\Address\Rate $shippingRate
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->quoteRepository = $quoteRepository;
        $this->shippingRate = $shippingRate;
    }

    public function execute(Observer $observer) {
        /** @var \Magento\Catalog\Model\Product\Interceptor $product */
        $quote = $this->checkoutSession->getQuote();
        $myfile = file_put_contents('/var/www/html/certification/var/log/lidn.log', $quote->getShippingAddress()->getId().PHP_EOL , FILE_APPEND | LOCK_EX);
        $myfile = file_put_contents('/var/www/html/certification/var/log/lidn.log', $quote->getShippingAddress()->getShippingMethod().PHP_EOL , FILE_APPEND | LOCK_EX);
        $quote->getShippingAddress()->setShippingMethod('tablerate_bestway');
        $myfile = file_put_contents('/var/www/html/certification/var/log/lidn.log', $quote->getShippingAddress()->getShippingMethod().PHP_EOL , FILE_APPEND | LOCK_EX);
        $quote->save();
        //$myfile = file_put_contents('/var/www/html/certification/var/log/lidn.log', $quote->getShippingAddress()->getShippingMethod().PHP_EOL , FILE_APPEND | LOCK_EX);
    }
}