# Description
LXC node monitoring through Zabbix.  
LXC containers monitoring through Zabbix.  
Template "Template LXC Node" finds all containers, creates new hosts and apply template "Template LXC CT" on them.  
This repository is forked from https://github.com/Lelik13a/Zabbix-LXC

# Dependencies
php, sudo, zabbix-agent.

Installation
============
1. `$ sudo ./install.sh`
2. Import "zbx_templates/Template_LXC_CT.xml"
3. Import "zbx_templates/Template_LXC_Node.xml"  
If you using Proxmox "zbx_templates/Template_LXC_Node_Proxmox.xml"
4. Apply template "Template_LXC_Node" to LXC hardware node (otherwise known as host system).
