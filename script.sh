sudo mkdir -p /var/hpasmcli


while true;
do
	echo Last fetch: $(date -u +"%Y-%m-%d %H:%M:%S") > /var/hpasmcli/status
	sudo hpasmcli -s "show fan; show temp; show powermeter; show powersupply" >> /var/hpasmcli/status
	sleep 10
done;
