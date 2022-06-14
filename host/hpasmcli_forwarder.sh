#!/usr/bin/env bash


while true;
do
	echo Last fetch: $(date -u +"%Y-%m-%d %H:%M:%S") > /var/hpasmcli/status
	hpasmcli -s "show fan; show temp; show powermeter; show powersupply" >> /var/hpasmcli/status
	sleep 10
done;
