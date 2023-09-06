<?php

namespace iMuis\connection;

use iMuis\config\config;

class connection
{

    private $config;

    public function __construct()
    {
        $this->config = new config();
    }

    function Login()
    {
        $postdata_str = 'PARTNERKEY=' . $this->config->developmentPartnerKey . '&OMGEVINGSCODE=' . $this->config->developmentOmgevingsCode . '&ACTIE=LOGIN';

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata_str
            )
        );
        $context  = stream_context_create($opts);
        return file_get_contents('https://cloudswitch.imuisonline.com/ws1_api.aspx', false, $context);
    }

    function Logout($aPartnerkey, $aOmgevingscode, $aSessionId)
    {
        $aPartnerkkey = $this->config->developmentPartnerKey;;
        $aOmgevingsCode = $this->config->developmentOmgevingsCode;
        $postdata_str = 'PARTNERKEY=' . $aPartnerkey . '&OMGEVINGSCODE=' . $aOmgevingscode . '&SESSIONID=' . $_SESSION['imuis_session_id'] . '&ACTIE=LOGOUT';

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata_str
            )
        );
        $context  = stream_context_create($opts);
        return file_get_contents('https://cloudswitch.imuisonline.com/ws1_api.aspx', false, $context);
    }

    public function setSessionId()
    {
        $sessionId = simplexml_load_string($this->Login())->SESSION->SESSIONID;
        $_SESSION['imuis_session_id'] = $sessionId;
        return $sessionId;
    }

    public function initializeConnection()
    {
        $error = "";
        try {
            $this->Login();
            $this->setSessionId();
        }
        catch(\Exception $exception) {
            $error = $exception->getMessage();
        }

        if(!empty($error))
            return $error;

        return "Success";
    }

}