<?php

namespace iMuis\config;

class config
{
    public $developmentPartnerKey = "abcdefghijklmnopqrstuvwxyz";
    public $developmentOmgevingsCode = "00000";
    public $omgevingsCode = "";
    public $partnerKey = "";

    public function setPartnerKey($partnerKey)
    {
        $this->partnerKey = $partnerKey;
    }

    public function setOmgevingsCode($omgevingsCode)
    {
        $this->omgevingsCode = $omgevingsCode;
    }
}