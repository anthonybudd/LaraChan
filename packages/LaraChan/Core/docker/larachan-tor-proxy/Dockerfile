FROM ubuntu:16.04

# Base packages
RUN apt-get update && \
    apt-get -y install \
    nginx \
    wget \
    torsocks ntpdate

# Build Tor
RUN apt-get install -y git build-essential automake libevent-dev libssl-dev zlib1g-dev
RUN git clone https://git.torproject.org/tor.git /tmp/tor
WORKDIR /tmp/tor
RUN ./autogen.sh
RUN ./configure --disable-asciidoc
RUN make
RUN make install

# Main script
ADD ./main.sh /main.sh
RUN mkdir /web

# Tor Config
ADD ./torrc /etc/tor/torrc

# Add nginx default configuration 
ADD ./nginx.conf /etc/nginx/nginx.conf
ADD ./site.conf /web/site.conf

# Configure nginx logs to go to Docker log collection (via stdout/stderr)
RUN ln --symbolic --force /dev/stdout /var/log/nginx/access.log
RUN ln --symbolic --force /dev/stderr /var/log/nginx/error.log

# Configuration files and data output folder
VOLUME /web
WORKDIR /web

ENTRYPOINT ["/main.sh"]
