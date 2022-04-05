<?php

namespace Smart\CustomerValidate\Plugin;

use Magento\Quote\Model\Quote\Address;
use Smart\CustomerValidate\Model\Phone;

class SetTelephone
{

    protected $modelPhone;

    public function __construct(Phone $modelPhone)
    {
        $this->modelPhone = $modelPhone;
    }

    /**
     * @param Address $subject
     * @param $telephone
     * @return string|int|null
     */
    public function beforeSetTelephone(Address $subject, $telephone)
    {
        return $this->modelPhone->preparePhone($telephone);
    }
}