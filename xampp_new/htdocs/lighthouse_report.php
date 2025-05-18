<?php
$command = "lighthouse http://localhost --quiet --only-categories=accessibility,seo --output=json > report.json";
$output = shell_exec($command);

if ($output === null) {
    die("Hiba: Nem sikerült lefuttatni a Lighthouse-t.");
}

$report = json_decode($output, true);
print_r($report);
?>
