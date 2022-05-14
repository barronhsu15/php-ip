<?php

namespace Barronhsu15\IP;

require_once __DIR__. '/vendor/autoload.php';

$ipv4 = new IPv4();
$ip = '192.168.1.1';
$network = '192.168.1.0';
$mask = '255.255.255.0';
var_dump($ipv4->match($ip, $network, $mask));  // => bool(true)

$ipv4 = new IPv4();
$ip = '192.168.1.1';
$network = '192.168.1.0';
$mask = 24;
var_dump($ipv4->match($ip, $network, $mask));  // => bool(true)

$ipv6 = new IPv6();
$ip = '2001:0db8:86a3:08d3::7344';
$network = '2001:0db8:86a3:08d3::';
$mask = 'ffff:ffff:ffff:ffff::';
var_dump($ipv6->match($ip, $network, $mask));  // => bool(true)

$ipv6 = new IPv6();
$ip = '2001:0db8:86a3:08d3::7344';
$network = '2001:0db8:86a3:08d3::';
$mask = 64;
var_dump($ipv6->match($ip, $network, $mask));  // => bool(true)
