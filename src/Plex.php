<?php
  /**
  * Simple library for Plex API
  *
  * PHP version 7
  *
  * @author SneakyOnigiri
  */

  class Plex{
    /**
    * @var string $_host            Remote IP adress
    * @var string $_port            Remote Plex port (Default: 32400)
    * @var string $_access_token    Must contain Plex token
    * @var string $_format          Specify returned data format
    * @var string $_base_url        Base URL for requests
    */
    private $_host;
    private $_port;
    private $_access_token;
    private $_format;
    private $_base_url;

    /**
    * Create Plex object
    *
    * @param string $host     Remote IP adress
    * @param string $port     Remote port
    * @param string $token    Plex access token
    * @param string $format   Data format
    *
    */
    public function __construct(string $host, string $port, string $token, string $format = 'json'){
      $this->_host = $host;
      $this->_port = $port;
      $this->_access_token = $token;
      $this->_format = $format;
      $this->_base_url = $this->_host . ':' . $this->_port;
    }

    /**
    * Get info about transcode bitrate and Plex authentication
    *
    * @return string|array    Information in json format or as an associative array
    */
    public function GetInfo(){
      $ch = curl_init($this->_base_url . '/');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'X-Plex-Token: ' . $this->_access_token)
      );
      $json     = curl_exec($ch);
      if ($this->_format == 'array'){
        $array = json_decode($json);
        return $array;
      }
      else {
        return $json;
      }
    }

    /**
    * Get all currently playing media
    *
    * @return string|array    Playing media in json format or as an associative array
    */
    public function NowPlaying(){
      $ch = curl_init($this->_base_url . '/status/sessions');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'X-Plex-Token: ' . $this->_access_token)
      );
      $json     = curl_exec($ch);
      if ($this->_format == 'array'){
        $array = json_decode($json);
        return $array;
      }
      else {
        return $json;
      }
    }

    /**
    * Get latest played media
    *
    * @return string|array    All played media (May be heavy) in json format or as an associative array
    */
    public function GetHistory(){
      $ch = curl_init($this->_base_url . '/status/sessions/history/all');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'X-Plex-Token: ' . $this->_access_token)
      );
      $json     = curl_exec($ch);
      if ($this->_format == 'array'){
        $array = json_decode($json);
        return $array;
      }
      else {
        return $json;
      }
    }

    /**
    * Search for a media in the library
    *
    * @param string           String to search
    *
    * @return string|array    All media containing the string in json format or as an associative array
    */
    public function Search(string $query){
      $query = filter_var($query, FILTER_SANITIZE_ENCODED);
      $ch = curl_init($this->_base_url . '/search?query=' . $query);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'X-Plex-Token: ' . $this->_access_token)
      );
      $json     = curl_exec($ch);
      if ($this->_format == 'array'){
        $array = json_decode($json);
        return $array;
      }
      else {
        return $json;
      }
    }

    /**
    * Get all sections from the remote host
    *
    * @return string|array    All sections in json format or as an associative array
    */
    public function GetSections(){
      $ch = curl_init($this->_base_url . '/library/sections');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'X-Plex-Token: ' . $this->_access_token)
      );
      $json     = curl_exec($ch);
      if ($this->_format == 'array'){
        $array = json_decode($json);
        return $array;
      }
      else {
        return $json;
      }
    }

    /**
    * Browse a section and filter it's media
    *
    * @param int    $id        ID of the section
    * @param string $key       Filter(all | unwatched | newest | recentlyAdded | recentlyViewed | recentlyViewedShows | onDeck)
    *
    * @return string|array     Filtered media of the section in json format or as an associative array
    */
    public function BrowseSection(int $id, $key = 'all'){
      $ch = curl_init($this->_base_url . '/library/sections/' . $id . '/' . $key);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'X-Plex-Token: ' . $this->_access_token)
      );
      $json     = curl_exec($ch);
      if ($this->_format == 'array'){
        $array = json_decode($json);
        return $array;
      }
      else {
        return $json;
      }
    }

    /**
    * Remove a section from the remote host library
    *
    * @param int $id          ID of the section to remove
    *
    * @return bool            Return true if successful, false if the section wasn't found
    */
    public function DeleteSection(int $id){
      $ch = curl_init($this->_base_url . '/library/sections/' . $id . '/');
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-Plex-Token: ' . $this->_access_token
      ));
      curl_exec($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpCode == 404){
        return false;
      }
      else {
        return true;
      }
    }

    /**
    * Get the server preferences
    *
    * @return string|array    Return server preferences in json format or as an associative array
    */
    public function GetPreferences(){
      $ch = curl_init($this->_base_url . '/:/prefs');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'X-Plex-Token: ' . $this->_access_token)
      );
      $json     = curl_exec($ch);
      if ($this->_format == 'array'){
        $array = json_decode($json);
        return $array;
      }
      else {
        return $json;
      }
    }

    /**
    * Get the local list of servers
    *
    * @return string|array    Return the local list of servers in json format or as an associative array
    */
    public function GetServers(){
      $ch = curl_init($this->_base_url . '/servers');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'X-Plex-Token: ' . $this->_access_token)
      );
      $json     = curl_exec($ch);
      if ($this->_format == 'array'){
        $array = json_decode($json);
        return $array;
      }
      else {
        return $json;
      }
    }

    /**
    * Get the list of paused shows
    *
    * @return string|array    Return the list of paused shows in json format or as an associative array
    */
    public function GetOnDeck(){
      $ch = curl_init($this->_base_url . '/library/onDeck');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'X-Plex-Token: ' . $this->_access_token)
      );
      $json     = curl_exec($ch);
      if ($this->_format == 'array'){
        $array = json_decode($json);
        return $array;
      }
      else {
        return $json;
      }
    }

    /**
    * Get a library image (Artwork, thumb, ...)
    *
    * @param string $url          Relative path to the image (e.g /library/metadata/94/thumb/1490139645)
    * @param int    $width        Desired width for image
    * @param int    $height       Desired height for image
    *
    * @return resource            Return image
    */
    public function GetPhoto(string $url, int $width, int $height){
      $url = filter_var($url, FILTER_SANITIZE_ENCODED);
      $ch = curl_init($this->_base_url . '/photo/:/transcode?url=' . $url . '&width=' . $width . '&height=' . $height);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-Plex-Token: ' . $this->_access_token)
      );
      $image     = curl_exec($ch);
      return $image;
    }

    /**
    * Get Plex account information (Based on token)
    *
    * @return string|array        Return Plex account information in json format or as an associative array
    */
    public function MyAccount(){
      $ch = curl_init($this->_base_url . '/myplex/account');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'X-Plex-Token: ' . $this->_access_token)
      );
      $json     = curl_exec($ch);
      if ($this->_format == 'array'){
        $array = json_decode($json);
        return $array;
      }
      else {
        return $json;
      }
    }
  }
 ?>
