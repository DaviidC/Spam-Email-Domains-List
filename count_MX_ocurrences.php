<?php


$blocked_emails = []; // Copy from bad_domains.php

$results = [];

foreach ($blocked_emails as $domain) {
    $domain = $domain.'.';
    $res=dns_get_record($domain, DNS_MX);
    if ($res !== false && !empty($res)) {
        if (isset($res[0])) {
            $mx_record_target = $res[0]['target'];
            if (!array_key_exists($mx_record_target, $results)) {
                $results[$mx_record_target] = 0;
            }
            $results[$mx_record_target]++;
            echo "COUNTED".PHP_EOL;
        } else {
            echo $domain.print_r($res, true).PHP_EOL;
        }
    } else {
        echo "ERROR".PHP_EOL;
    }
}

$fp = fopen('file.txt', 'w');
fwrite($fp, print_r($results, true));
fclose($fp);
