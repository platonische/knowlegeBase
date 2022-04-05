<?php

namespace Smart\CustomerValidate\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Smart\CustomerValidate\Model\Phone;

class PrepareTelephone implements ObserverInterface
{

    protected $modelPhone;

    public function __construct(Phone $modelPhone)
    {
        $this->modelPhone = $modelPhone;
    }

    /**
     * Prepare telephone number
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $customer_address = $observer->getCustomerAddress();
        $telephone = $customer_address->getTelephone();

        $telephone = $this->modelPhone->preparePhone($telephone);

        $customer_address->setTelephone($telephone);
    }
}
