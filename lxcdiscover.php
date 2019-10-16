#!/usr/bin/php

<?php
$proxmox = checkProxmox();
$hostname = exec('hostname');

$ctid = shell_exec("pct list | awk '{print $1}' | sed -r 's/(.*)/\\1/g' | sed -e '1d'");
$array_ctid = explode("\n", $ctid);
$array_ctid = array_splice($array_ctid, 0, count($array_ctid)-1 );

$ct_status = shell_exec("pct list | awk '{print $2}'| sed -e '1d'");
$array_ct_status = explode("\n", $ct_status);
$array_ct_status = array_splice($array_ct_status, 0, count($array_ct_status)-1 );

echo "{\n";
echo "\t\"data\":[\n";

if ($proxmox === 1) {
    foreach ($array_ctid as $key => $row) {
        if ($array_ct_status[$key] != "running") {
            continue;
        }

        $name = getVename($row);
        $status = getStatus($row);

        if (is_null($name) || is_null($status)) {
            continue;
        }

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
    $name = exec("/bin/cat /etc/pve/lxc/${ctid}.conf | grep \"hostname\" | awk '{print $2}'");
    return trim($name);
}

function getStatus($ctid)
{
    $state = exec("/usr/bin/lxc-info -s -n ${ctid} | awk '{print $2}'");
    return trim($state);
}

function checkProxmox()
{
    $uname  = exec('uname -r');
    return strpos($uname, "pve") !== false ? 1 : 0;
}
