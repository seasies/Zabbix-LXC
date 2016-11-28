#!/usr/bin/php

<?php
$proxmox = checkProxmox();
$hostname = exec('hostname');

$ctid = shell_exec('/usr/bin/lxc-ls -1');
$array_ctid = explode("\n", $ctid);
$array_ctid = array_splice($array_ctid, 0, count($array_ctid)-1 );

echo "{\n";
echo "\t\"data\":[\n";

if ($proxmox === 1) {
    foreach ($array_ctid as $key => $row) {
        $name = getVename($row);
        $status = getStatus($row);

        echo "\t{\n";
        echo "\t\t\"{#CTID}\":\"${row}\",\n";
        echo "\t\t\"{#CTNAME}\":\"${name}\",\n";
        echo "\t\t\"{#CTSTATUS}\":\"${status}\",\n";
        echo "\t\t\"{#VENAME}\":\"${hostname}\"\n";
        echo $row !== end($array_ctid) ? "\t},\n" : "\t}\n";
    }
} else {
    foreach ($array_ctid as $key => $row) {
        $status = getStatus($row);

        echo "\t{\n";
        echo "\t\t\"{#CTID}\":\"${row}\",\n";
        echo "\t\t\"{#CTSTATUS}\":\"${status}\",\n";
        echo "\t\t\"{#VENAME}\":\"${hostname}\"\n";
        echo $row !== end($array_ctid) ? "\t},\n" : "\t}\n";
    }
}

echo "\t]\n";
echo "}\n";

function getVename($ctid)
{
    $name = shell_exec("/bin/cat /etc/pve/lxc/${ctid}.conf | grep \"hostname\" | awk '{print $2}'");
    return trim($name);
}

function getStatus($ctid)
{
    $state = shell_exec("/usr/bin/lxc-info -s -n ${ctid} | awk '{print $2}'");
    return trim($state);
}

function checkProxmox()
{
    $uname  = shell_exec('uname -r');
    return strpos($uname, "pve") !== false ? 1 : 0;
}
