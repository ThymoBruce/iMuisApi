<?php

include '../Modals/Debtor.php';
include '../Modals/journalpost.php';

include '../config/config.php';
include '../config/connection.php';

include '../Debtors.php';
include '../Finance.php';
include '../object.php';

$connection = new iMuis\connection\connection();
$debtors = new \iMuis\Debtors\Debtors();
$finance = new \iMuis\Finance\Finance();
$object = new \iMuis\Object\objectClass();

$connection->Login();
$connection->setSessionId();
//$value = $debtors->searchDebtor("test", "123", "5");

$testDebtorData = [
    'NAAM' => "Thymo",
    'EMAIL' => "test@testweb.nl",
    'ZKSL' => "test thymo",
    'HNR' => "25B",
    'POSTCD' => "6432BS",
];

$number = -(double)"2,95";
$testJournalPostData = [
    'JR' => date("Y"),
    'PN' => date("n"),
    'TEGREK' => "2600",
    'DAT' => date("j-n-Y"),
    'OPM' => "TEST",
    'OMSCHR' => "test",
    'BOEKSTUK' => "Bkst_2018226121722",
    'DAGB' => "30",
    'REK' => "2500",
    'FACT' => 2018022601,
    'BEDRBOEK' => "1000",
    'BTW' => "12",
    'BTWBED' => -1000,
    'DATVERV' => date("j-n-Y", strtotime("+14 days")),
];

$debtor = $debtors->searchDebtor(10824, "robenthymo@gmail.com");
$debtor_xml = simplexml_load_string($debtor);
$debtorNumber = null;
if(!empty($debtor_xml)) {
    echo $debtor_xml->DATA->NR;
    $debtorNumber = $debtor_xml->DATA->NR;
}
else {
    try {
        $debtor = new \iMuis\Modals\Debtor();
        $debtor->setEmail("prive@prive.nl");
        $debtor->setName("test creation");
        $debtor->setMobile("0657885851");
        $debtor->setStreet("teststraat");
        $debtor->setHouseNumber("32");
        $debtor->setResidence("test plaats");
        $newDebtor = $debtors->createDebtor($debtor);
        $debtorNumber = $newDebtor;
        echo $newDebtor;
    }
    catch(\Exception $e){
        echo $e->getMessage();
    }
}

//Create journalpost using modal
$journalPost = new \iMuis\Modals\journalpost();

$journalPost->setBEDRBOEK(2000);
$journalPost->setOMSCHR("test");
$journalPost->setPN("6");
$journalPost->setTEGREK($debtorNumber);
$journalPost->setJR(date("Y"));
$journalPost->setFACT(2018022601);
$journalPost->setOPM("slechte betaler");
$journalPost->setDAT(date("j-n-Y"));
$journalPost->setBTW(21);
$journalPost->setREK(2500);
$journalPost->setDATVERV(strtotime(date("j-n-Y"), strtotime("+14 days")));
$journalPost->setBOEKSTUK("BKSTK_1gwgewgewgerwg");

$testPost = $finance->createJournalpost($journalPost);
echo "<br>";
echo $testPost;

