<?php

header_remove('Access-Control-Allow-Methods');
header_remove('Access-Control-Allow-Origin');
header_remove('Access-Control-Allow-Headers');
header_remove('Access-Control-Allow-Credentials');

$allowed_host=array('172.31.61.248:156','localhost','localhost:156','172.31.61.248','103.74.215.40','103.74.215.40:156');


if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $allowed_host)) 
{
    header($_SERVER['SERVER_PROTOCOL'] . ' 421 Misdirected Request');

echo "<html><head>
<title>421 Misdirected Request</title>
</head><body>
<h1>Misdirected Request</h1>
<p>The client needs a new connection for this
request as the requested host name does not match
the Server Name Indication (SNI) in use for this
connection.</p>
</body></html>";

    exit;
}

