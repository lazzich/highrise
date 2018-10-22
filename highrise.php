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

  echo $options[CURLOPT_USERPWD];

  $response = curl_exec($ch);
  curl_close($ch);
  return $response;
}

$data = getResponse($highrise_url,$userpwd);
$xml = new SimpleXMLElement($data);
print_r($xml);

echo "<hr />";

echo $xml->company->{'contact-data'}->{'email-addresses'}->{'email-address'}->{'address'}."<br />";
echo $xml->company->{'contact-data'}->{'addresses'}->{'address'}->street;

?>
