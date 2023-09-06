<?php

namespace iMuis\Finance;

use iMuis\connection\connection;
use iMuis\config\config;

class Finance
{
    private $config;
    private $connection;
    public function __construct()
    {
        $this->config = new config();
        $this->connection = new connection();
    }

    public function findInvoice($searchFields)
    {
        foreach ($searchFields as $key => $field) {
            if(empty($field))
                continue;

            if($key == "NR"){
                $searchString = "
                <NewDataSet>
                <Table1>
                <TABLE>BOE</TABLE>
                <SELECTFIELDS>EMAIL\tNAAM\tHNR\tPOSTCD\tNR</SELECTFIELDS>
                <WHEREFIELDS>NR</WHEREFIELDS>
                <WHEREOPERATORS>=</WHEREOPERATORS>
                <WHEREVALUES>$field</WHEREVALUES>
                <ORDERBY>NR</ORDERBY>
                <MAXRESULT>0</MAXRESULT>
                <PAGESIZE>10000</PAGESIZE>
                <SELECTPAGE>1</SELECTPAGE>
                </Table1></NewDataSet>";
                $value = $this->stamTabelRecordsData($searchString);
                if (simplexml_load_string($value)->METADATA->RECORDCOUNT > 0) {
                    return htmlentities($value);
                }
            }

            $searchString = "
                <NewDataSet>
                <Table1>
                <TABLE>BOE</TABLE>
                <SELECTFIELDS>EMAIL\tNAAM\tHNR\tPOSTCD\tNR</SELECTFIELDS>
                <WHEREFIELDS>$key</WHEREFIELDS>
                <WHEREOPERATORS>LIKE</WHEREOPERATORS>
                <WHEREVALUES>$field</WHEREVALUES>
                <ORDERBY>NR</ORDERBY>
                <MAXRESULT>0</MAXRESULT>
                <PAGESIZE>10000</PAGESIZE>
                <SELECTPAGE>1</SELECTPAGE>
                </Table1></NewDataSet>";
            $value = $this->stamTabelRecordsData($searchString);
            if (simplexml_load_string($value)->METADATA->RECORDCOUNT > 0) {
                return htmlentities($value);
            }
        }
        return false;
    }

    public function createJournalpost($debtorData)
    {
        $debtorData = $debtorData->toArray();
        $xmlstring = "
                    <NewDataSet>
                    <BOE>
                    <JR>". $debtorData["JR"] ."</JR>
                    <PN>" . $debtorData["PN"]. "</PN>
                    <TEGREK>2600</TEGREK>
                    <DAT>". $debtorData["DAT"] ."</DAT>
                    <OPM>". $debtorData["OPM"] ."</OPM>
                    <OMSCHR>" .$debtorData["OMSCHR"]. "</OMSCHR>
                    <BOEKSTUK>".$debtorData["BOEKSTUK"]."</BOEKSTUK>
                    <DAGB>30</DAGB>
                    <REK>". $debtorData["REK"] ."</REK>
                    <FACT>". $debtorData["FACT"] ."</FACT>
                    <BEDRBOEK>". $debtorData["BEDRBOEK"] ."</BEDRBOEK>
                    <BTW>". $debtorData["BTW"] ."</BTW>
                    <DATVERV> ". $debtorData["DATVERV"] ." </DATVERV> 
                    </BOE>
                    </NewDataSet>";
        $postdata_str = 'PARTNERKEY=' . $this->config->developmentPartnerKey . '&OMGEVINGSCODE=' . $this->config->developmentOmgevingsCode . '&SESSIONID=' . $this->connection->setSessionId() . '&ACTIE=CREATEJOURNAALPOST' . '&JOURNAALPOST=' . $xmlstring;

//        var_dump($postdata_str);
//        die();

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata_str
            )
        );
        $context = stream_context_create($opts);

        try {
            return file_get_contents('https://cloudswitch.imuisonline.com/ws1_api.aspx', false, $context);
        }
        catch(\Exception $exception){
            return false;
        }
    }

    public function createJournalPostXmlData($debtordata)
    {
        $xmlData = "";
        foreach ($debtordata as $key => $value) {
            $string = " <$key>" . $value . "</$key>";
            $xmlData .= $string;
        }
        $xmlString = "<NewDataSet><BOE>$xmlData</BOE></NewDataSet>";
        return $xmlString;
    }

}