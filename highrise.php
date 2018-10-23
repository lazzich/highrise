<?php

require_once(".env");

function getResponse($url,$password) {

  $ch = curl_init($url);
  $options = [];
  $options[CURLOPT_HTTPGET] = true;
  $options[CURLOPT_VERBOSE] = true;
  $options[CURLOPT_SSL_VERIFYPEER] = false;
  $options[CURLOPT_SSL_VERIFYHOST] = false;
  $options[CURLOPT_RETURNTRANSFER] = true;
  $options[CURLOPT_USERPWD] = $password;
  $options[CURLOPT_HTTPHEADER] = array('Accept: application/xml', 'Content-Type: application/xml');

  curl_setopt_array($ch, $options);

  $response = curl_exec($ch);
  curl_close($ch);
  return $response;
}

$data = getResponse($highrise_url,$userpwd);
$xml = new SimpleXMLElement($data);

echo $xml->company->name."<br />";
echo $xml->company->{'contact-data'}->{'email-addresses'}->{'email-address'}->{'address'}."<br />";

foreach ($xml->company->{'contact-data'}->{'phone-numbers'}->{'phone-number'} as $phonenumber) {
echo $phonenumber->{'number'}." - ".$phonenumber->{'location'}."<br />";
}

foreach ($xml->company->{'contact-data'}->{'web-addresses'}->{'web-address'} as $webaddress) {
echo $webaddress->{'url'}."<br />";
}

echo $xml->company->{'contact-data'}->{'addresses'}->{'address'}->street."<br />";
echo $xml->company->{'contact-data'}->{'addresses'}->{'address'}->zip." ";
echo $xml->company->{'contact-data'}->{'addresses'}->{'address'}->city."<br />";

?>
