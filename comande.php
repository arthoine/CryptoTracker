<?php
$output=null;
$retval=null;
exec('/usr/local/php7.4/bin/php  symfony/bin/console app:create', $output, $retval);
echo "Returned with status $retval and output:\n";
echo 'php bin/console app:create';
print_r($output);

