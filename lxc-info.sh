#!/bin/bash -eu

ctid=`echo $1 | sed -e 's/[^0-9]//g'`
status=$2

case "$status" in
  "usedmem" ) echo `/usr/bin/sudo /usr/bin/lxc-info -H --name ${ctid} | grep "Memory use:" | awk '{print $3}'` ;;
  "status" ) echo `/usr/bin/sudo /usr/bin/lxc-info --name ${ctid} | grep "State:" | awk '{print $2}'` ;;
  "ip" ) echo `/usr/bin/sudo /usr/bin/lxc-info --name ${ctid} | grep "IP:" | awk '{print $2}'` ;;
  "cpu" ) echo `/usr/bin/sudo /usr/bin/lxc-info -H --name ${ctid} | grep "CPU use:" | awk '{print $3/1000000000}'` ;;
  "in" ) echo `/usr/bin/sudo /usr/bin/lxc-info -H --name ${ctid} | grep "RX bytes:" | awk '{print $3}' | awk '{s += $1} END {print s}'` ;;
  "out" ) echo `/usr/bin/sudo /usr/bin/lxc-info -H --name ${ctid} | grep "TX bytes:" | awk '{print $3}' | awk '{s += $1} END {print s}'` ;;
esac
