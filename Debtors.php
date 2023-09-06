<?php

namespace iMuis\Debtors;

use iMuis\config\config;
use iMuis\connection\connection;
use iMuis\Modals\Debtor;

class Debtors
{
    private $config;
    private $connection;

    public function __construct()
    {
        $this->config = new config();
        $this->connection = new connection();
    }

    public function searchDebtor($nmr = null,$email = null, $zipcode = null, $housenumber = null)
    {
        $selectFields = $this->getSelectFields();

//        var_dump($selectFields);
//        var_dump("NR\tNAAM\tSTRAAT\tMOBIEL\tPLAATS\tADRES\tNAAM2");

        $searchFields = [
            "EMAIL" => $email,
            "POSTCD" => $zipcode,
            "HNR" => $housenumber,
            "NR" => $nmr,
        ];

        foreach ($searchFields as $key => $field) {
            if(empty($field))
                continue;

            if($key == "NR"){
                $searchString = "
                <NewDataSet>
                <Table1>
                <TABLE>DEB</TABLE>
                <SELECTFIELDS>$selectFields</SELECTFIELDS>
                <WHEREFIELDS>NR</WHEREFIELDS>
                <WHEREOPERATORS>=</WHEREOPERATORS>
                <WHEREVALUES>$nmr</WHEREVALUES>
                <ORDERBY>NR</ORDERBY>
                <MAXRESULT>0</MAXRESULT>
                <PAGESIZE>10000</PAGESIZE>
                <SELECTPAGE>1</SELECTPAGE>
                </Table1></NewDataSet>";
                $value = $this->stamTabelRecordsData($searchString);
                if (simplexml_load_string($value)->METADATA->RECORDCOUNT > 0) {
                    return $value;
                }
            }

            $searchString = "
                <NewDataSet>
                <Table1>
                <TABLE>DEB</TABLE>
                <SELECTFIELDS>$selectFields</SELECTFIELDS>
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
                return $value;
            }
        }

        return false;
    }

    public function stamTabelRecordsData($searchString)
    {
        $postdata_str = 'PARTNERKEY=' . $this->config->developmentPartnerKey . '&OMGEVINGSCODE=' . $this->config->developmentOmgevingsCode . '&SESSIONID=' . $this->connection->setSessionId() . '&ACTIE=GETSTAMTABELRECORDS' . '&SELECTIE=' . $searchString;
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata_str
            )
        );
        $context = stream_context_create($opts);
        return file_get_contents('https://cloudswitch.imuisonline.com/ws1_api.aspx', false, $context);
    }



    public function createDebtor(Debtor $debtorObject, $debtorData = null)
    {
        $xmlstring = trim($debtorObject->convertToXml());

        $postdata_str = 'PARTNERKEY=' . $this->config->developmentPartnerKey . '&OMGEVINGSCODE=' . $this->config->developmentOmgevingsCode . '&SESSIONID=' . $this->connection->setSessionId() . '&ACTIE=CREATESTAMTABELRECORD' . '&STAMTABEL=' . $xmlstring;

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata_str
            )
        );
        $context = stream_context_create($opts);
        return file_get_contents('https://cloudswitch.imuisonline.com/ws1_api.aspx', false, $context);
    }

    public function createDebtorXmlData($debtordata)
    {
        $xmlString = '<NewDataSet>   <METADATA>     <TABLE>DEB</TABLE>   </METADATA><DATA>';

        foreach ($debtordata as $key => $value) {
            $xmlString .= "<$key>" . $value . "</$key>";

        }

        $xmlString .= "</DATA></NewDataSet>";
        return $xmlString;
    }

    public function getSelectFields()
    {
        $debtor = new Debtor();
        $properties = $debtor->getProperties();
        $selectFields = "";
        foreach($properties as $property){
            if(empty($property))
                continue;
            $selectFields .= strtoupper($property);
            $selectFields .= "\t";
        }
        $selectFields = substr($selectFields, 0, -1);
        return $selectFields;
    }
}