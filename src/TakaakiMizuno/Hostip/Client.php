<?php

namespace TakaakiMizuno\Hostip;

class Client {

    private static $END_POINT = "http://api.hostip.info/get_json.php";
    private static $PROPERTIES =  ['country_name', 'country_code','city','ip','lat','lng'];
    public $error;

    function __construct($ip) {
        $this->error = false;
        foreach( self::$PROPERTIES as $name ){
            $this->$name = "";
        }
        if( !$this->_checkIp($ip) ){
            return;
        }
        $this->_getHost();
    }

    function __destruct() {
    }

    private function _checkIp($ip) {
        $check = preg_match ( "/\A(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\Z/" , $ip, $matches);
        if( $check !== 1 ) {
            $this->error = true;
            return false;
        }
        for( $i=0; $i < 4; $i++ ){
            $val = intval($matches[$i]);
            if( $val < 0 && $val > 255 ){
                $this->error = true;
                return false;
            }
        }
        $this->ip = $ip;
        return true;
    }

    private function _getHost(){
        print "hoge";
        print self::$END_POINT + "?position=true&ip=" . $this->ip;
        $response = \Unirest::get
            (
             self::$END_POINT . "?position=true&ip=" . $this->ip
             );
        if( $response->code < 200 || $response->code > 299 ){
            $this->error = true;
            return;
        }
        foreach(  self::$PROPERTIES as $name ){
            if (property_exists($response->body, $name)){
                $this->$name = $response->body->$name;
            }
        }
    }

}
