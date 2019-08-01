Zabbix-LXC
==========
LXC node monitoring through Zabbix.  
LXC containers monitoring through Zabbix.  
Template "Template LXC Node" finds all containers, creates new hosts and apply template "Template LXC CT" on them.  

Support Proxmox.

Dependencies
------------
php, sudo, zabbix-agent.

Installation
============
1. `$ sudo ./install.sh`
2. Import "zbx_templates/Template_LXC_CT.xml"
3. Import "zbx_templates/Template_LXC_Node.xml"  
If you using Proxmox "zbx_templates/Template_LXC_Node_Proxmox.xml"
4. Apply template "Template_LXC_Node" to LXC hardware node (otherwise known as host system).

Supported Proxmox version
-------------------------

- Proxmox 6.x
- Proxmox 5.x
- Proxmox 4.x
