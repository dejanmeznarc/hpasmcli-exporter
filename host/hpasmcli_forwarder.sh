#!/usr/bin/env bash

# Must be run as root and ran at boot!
# This file executes hpa command and outputs its ouptut to /var/hpasmcli/status. We do this because
# docker cant interact with host.

mkdir -p /var/hpasmcli

while true;
do
	echo Last fetch: $(date -u +"%Y-%m-%d %H:%M:%S") > /var/hpasmcli/status
	hpasmcli -s "show fan; show temp; show powermeter; show powersupply" >> /var/hpasmcli/status
	sleep 10
done;
