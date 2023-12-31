<?php

namespace iMuis;

use iMuis\Finance\Finance;
use iMuis\Debtors\Debtors;
use iMuis\config;
use iMuis\connection\connection;
use iMuis\Modals\Debtor;

class iMuis{

    private $finance;
    private $debtor;

    public function __construct(connection $connection, Finance $finance, Debtors $debtor)
    {
        $connection->initializeConnection();
        $this->finance = $finance;
        $this->debtor = $debtor;
    }

    public function setDebtorObject($name, $email, $zipcode, $housenumber, $street, $place, $phone)
    {
        $debtor = new Debtor();
        $debtor->setName($name);
        $debtor->setEmail($email);
        $debtor->setPostalCode($zipcode);
        $debtor->setResidence($place);
        $debtor->setHouseNumber($housenumber);
        $debtor->setStreet($street);
        $debtor->setMobile($phone);
        return $debtor;
    }

    public function createInvoice($invoice, array $debtorData, $newDebtor = null)
    {
        $debtor = $this->debtor->searchDebtor($debtorData["nr"] ?? null, $debtorData["email"],$debtorData["zipcode"],$debtorData["housenumber"]);
        if(empty($debtor) && !empty($newDebtor)){
            $debtor = $this->debtor->createDebtor($newDebtor);
        }
        else throw new \Exception("not able to find or create debtor");

        try {
            $invoice = $this->finance->createJournalpost($invoice);
        }
        catch(\Exception $exception){
            return $exception->getMessage();
        }

        return false;
    }
}