<?php

namespace Smart\CustomerValidate\Model;

class Phone
{
    const PATTERN_TO_DELETE_LETTERS = "/\D/";

    protected function getPattern()
    {
        return self::PATTERN_TO_DELETE_LETTERS;
    }

    public function preparePhone($phone)
    {
        $pattern = $this->getPattern();
        return preg_replace($pattern, "", $phone);
    }
}