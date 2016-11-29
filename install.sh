#!/bin/bash -eu
NORMAL=$(tput sgr0)
GREEN=$(tput setaf 2; tput bold)
YELLOW=$(tput setaf 3)
RED=$(tput setaf 1)

function red() {
    echo -e "$RED$*$NORMAL"
}

function green() {
    echo -e "$GREEN$*$NORMAL"
}

function yellow() {
    echo -e "$YELLOW$*$NORMAL"
}

function checkPhp() {
  if [ $? -eq 1 ]; then
    red "Please install php"
    exit 1
  fi
}

function checkSudo() {
  if [ $? -eq 1 ]; then
    red "Please install sudo"
    exit 1
  fi
}

checkPhp
checkSudo

\cp -rf lxcdiscover.php /etc/zabbix
\cp -rf lxc-attach.sh /etc/zabbix
\cp -rf lxc-cgroup.sh /etc/zabbix
\cp -rf lxc-info.sh /etc/zabbix

\cp -rf zabbix_agentd.d/lxc.conf /etc/zabbix/zabbix_agentd.d
\cp -rf sudoers.d/zabbix /etc/sudoers.d
chown root:root /etc/sudoers.d/zabbix ; chmod 440 /etc/sudoers.d/zabbix
chmod 755 /etc/zabbix/lxcdiscover.php /etc/zabbix/lxc-attach.sh /etc/zabbix/lxc-cgroup.sh /etc/zabbix/lxc-info.sh

set +e
ln -s /usr/local/bin/php /usr/bin/php > /dev/null 2>&1
set -e

systemctl restart zabbix-agent.service

green "Finished install."
echo  "Next you have to import template."
echo "If you using proxmox -> Template_LXC_Node_Proxmox.xml"
