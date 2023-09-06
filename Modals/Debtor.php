<?php

namespace iMuis\Modals;

class Debtor{

    private $id;
    private $email;
    private $name;
    private $postalCode;
    private $houseNumber;
    private $street;
    private $mobile;
    private $residence;
    private $iban;
    private $address;
    private $name2;
    private $vatCode;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPostalCode() {
        return $this->postalCode;
    }

    public function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
    }

    public function getHouseNumber() {
        return $this->houseNumber;
    }

    public function setHouseNumber($houseNumber) {
        $this->houseNumber = $houseNumber;
    }

    public function getStreet() {
        return $this->street;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    public function getResidence() {
        return $this->residence;
    }

    public function setResidence($residence) {
        $this->residence = $residence;
    }

    public function getIban() {
        return $this->iban;
    }

    public function setIban($iban) {
        $this->iban = $iban;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getName2()
    {
        return $this->name2;
    }

    /**
     * @param mixed $name2
     */
    public function setName2($name2)
    {
        $this->name2 = $name2;
    }

    /**
     * @return mixed
     */
    public function getVatCode()
    {
        return $this->vatCode;
    }

    /**
     * @param mixed $vatCode
     */
    public function setVatCode($vatCode)
    {
        $this->vatCode = $vatCode;
    }

    public function getProperties()
    {
        $properties = [];
        foreach($this as $key => $value){
            $key = $this->convertPropertyToIMUIS($key);
            $properties[] = $key;
        }

        return $properties;
    }

    public function convertPropertyToIMUIS($property)
    {
        switch ($property){
            case "name":
                return "NAAM";
            case "postalcode":
                return "POSTCD";
            case "name2":
                return "naam2";
            case "houseNumber":
                return "HNR";
            case "street":
                return "straat";
            case "mobile":
                return "mobiel";
            case "residence":
                return "plaats";
            case "address":
                return "adres";
            case "vatcode":
                return "btwnr";
            case "id":
                return "NR";
            case "email":
                return "email";
            case "iban":
                return "BNKIBAN";
        }
        return null;
    }

    public function convertToXml()
    {
        $xml = "<NewDataSet>   <METADATA> <TABLE>DEB</TABLE>   </METADATA><DATA>";
        foreach($this as $key => $value){
            $iMuisProperty = $this->convertPropertyToIMUIS($key);

            if(empty($iMuisProperty))
                continue;
            $xml .= " <$iMuisProperty>" . $value . "</$iMuisProperty> ";
        }
        $xml .= "</DATA></NewDataSet>";
        return $xml;
    }
}