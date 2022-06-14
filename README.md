# hpasmcli-scraper
Prometheus scraper for hpasmcli (HP prolaint)


## How to run?

### 1. Host setup
1. `sudo cp host/hpasmcli_forwarder.sh /usr/sbin/hpasmcli_forwarder` - Copy host script to host
2. `sudo chmod +x /usr/sbin/hpasmcli_forwarder` - Allow execution
3. `sudo cp host/hpasmcli_forwarder.service  /etc/systemd/system/hpasmcli_forwarder.service` - Setup systed service
4. `sudo chmod 644 /etc/systemd/system/hpasmcli_forwarder.service`
5. `sudo systemctl start hpasmcli_forwarder.service`
6. `sudo systemctl enable hpasmcli_forwarder.service`

#### Check if it works?
Check if systemd service works with `sudo service status hpasmcli_forwarder`.

Also check output of command with `cat /var/hpasmcli/status`. It should return something.


### 2. Docker setup

