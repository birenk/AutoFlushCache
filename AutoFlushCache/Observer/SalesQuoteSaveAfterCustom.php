<?php
namespace Biren\AutoFlushCache\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class SalesQuoteSaveAfterCustom implements ObserverInterface
{
    protected $checkoutSession;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession)
    {
        $this->checkoutSession = $checkoutSession;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('invoke function is calling');
        $quote = $observer->getQuote();
        $logger->info($quote->getId());
        $quote->getShippingAddress()->setShippingMethod('tablerate_bestway');
        $quote->save();

        /* @var $quote \Magento\Quote\Model\Quote */

        if($quote->getIsCheckoutCart())
        {
            $this->checkoutSession->getQuoteId($quote->getId());
        }
    }
}