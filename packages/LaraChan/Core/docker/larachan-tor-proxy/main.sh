#!/bin/bash

echo ''
echo 'LARACHAN TOR PROXY'
echo ''

echo '* Initializing local clock'
ntpdate -B -q 0.debian.pool.ntp.org
echo '* Starting Tor'
tor -f /etc/tor/torrc &
echo '* Starting nginx'
nginx &
sleep infinity
