<?php
$command = "pa11y http://localhost --standard WCAG2AA --runner axe --reporter json > results.json";
$output = shell_exec($command);

if ($output === null) {
    die("Hiba: Nem sikerült lefuttatni a Lighthouse-t.");
}

$report = json_decode($output, true);
print_r($report);
?>
