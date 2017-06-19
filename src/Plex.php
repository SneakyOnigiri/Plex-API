<?php
// yzVXpqpfQmybzVqnJ3Zp
  class Plex{
    private $_host;
    private $_port;
    private $_access_token;
    private $_base_url;

    public function __construct($host, $port, $token){
      $this->_host = $host;
      $this->_port = $port;
      $this->_access_token = $token;
      $this->_base_url = $this->_host . ':' . $this->_port;
    }

    public function Transcode(){
      $ch = curl_init($this->_base_url . '/');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'X-Plex-Token: ' . $this->_access_token)
      );
      $data     = curl_exec($ch);
      //$xml = simplexml_load_string($data);
      //$json = json_encode($xml);
      echo $data;
    }
  }
 ?>
