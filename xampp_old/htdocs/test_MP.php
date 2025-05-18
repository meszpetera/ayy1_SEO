<?php
$context = stream_context_create([
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false
    ]
]);

$data = file_get_contents("https://localhost", false, $context);
echo $data;

?>
