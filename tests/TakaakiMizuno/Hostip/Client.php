<?php

$superGlobals = array();

class ClientTest extends \PHPUnit_Framework_TestCase
{

	public function testGetHostIpInfo() {
        $hostip = new TakaakiMizuno\Hostip\Client("12.215.42.19");
        $this->assertEquals(false, $hostip->error);
        $this->assertEquals($hostip->country_name, "UNITED STATES");
        $this->assertEquals($hostip->country_code, "US");
    }

}
