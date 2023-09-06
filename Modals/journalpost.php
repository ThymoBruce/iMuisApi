<?php

namespace iMuis\Modals;

class journalpost{

    private $JR;
    private $PN;
    private $TEGREK;
    private $DAT;
    private $OPM;
    private $OMSCHR;
    private $BOEKSTUK;
    private $DAGB = 30;
    private $REK;
    private $FACT;
    private $BEDRBOEK;
    private $BTW;
    private $BTWBED;
    private $DATVERV;

    public function getJR() {
        return $this->JR;
    }

    public function setJR($JR) {
        $this->JR = $JR;
    }

    public function getPN() {
        return $this->PN;
    }

    public function setPN($PN) {
        $this->PN = $PN;
    }

    public function getTEGREK() {
        return $this->TEGREK;
    }

    public function setTEGREK($TEGREK) {
        $this->TEGREK = $TEGREK;
    }

    public function getDAT() {
        return $this->DAT;
    }

    public function setDAT($DAT) {
        $this->DAT = $DAT;
    }

    public function getOPM() {
        return $this->OPM;
    }

    public function setOPM($OPM) {
        $this->OPM = $OPM;
    }

    public function getOMSCHR() {
        return $this->OMSCHR;
    }

    public function setOMSCHR($OMSCHR) {
        $this->OMSCHR = $OMSCHR;
    }

    public function getBOEKSTUK() {
        return $this->BOEKSTUK;
    }

    public function setBOEKSTUK($BOEKSTUK) {
        $this->BOEKSTUK = $BOEKSTUK;
    }

    public function getDAGB() {
        return $this->DAGB;
    }

    public function setDAGB($DAGB) {
        $this->DAGB = $DAGB;
    }

    public function getREK() {
        return $this->REK;
    }

    public function setREK($REK) {
        $this->REK = $REK;
    }

    public function getFACT() {
        return $this->FACT;
    }

    public function setFACT($FACT) {
        $this->FACT = $FACT;
    }

    public function getBEDRBOEK() {
        return $this->BEDRBOEK;
    }

    public function setBEDRBOEK($BEDRBOEK) {
        $this->BEDRBOEK = $BEDRBOEK;
    }

    public function getBTW() {
        return $this->BTW;
    }

    public function setBTW($BTW) {
        $this->BTW = $BTW;
    }

    public function getBTWBED() {
        return $this->BTWBED;
    }

    public function setBTWBED($BTWBED) {
        $this->BTWBED = $BTWBED;
    }

    public function getDATVERV() {
        return $this->DATVERV;
    }

    public function setDATVERV($DATVERV) {
        $this->DATVERV = $DATVERV;
    }

    public function toArray()
    {
        $dataArray = [];
        foreach($this as $key => $value){
            $dataArray[$key] = $value;
        }

        return $dataArray;
    }

}
