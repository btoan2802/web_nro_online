<?php
require_once('core/config.php');
$res = $config->query("SELECT id, NAME FROM task_main_template LIMIT 5");
echo "Main Tasks:\n";
while($row = $res->fetch_assoc()) {
    echo $row['id'] . ": " . $row['NAME'] . "\n";
}

$resSub = $config->query("SELECT task_main_id, NAME, max_count, keyid FROM task_sub_template WHERE task_main_id IN (0, 1) ORDER BY task_main_id, keyid");
echo "\nSub Tasks:\n";
while($row = $resSub->fetch_assoc()) {
    echo "Main " . $row['task_main_id'] . " | Key " . $row['keyid'] . ": " . $row['NAME'] . " (max: " . $row['max_count'] . ")\n";
}

$resPlayer = $config->query("SELECT name, data_task FROM player LIMIT 3");
echo "\nPlayers:\n";
while($row = $resPlayer->fetch_assoc()) {
    echo $row['name'] . ": " . $row['data_task'] . "\n";
}
?>
