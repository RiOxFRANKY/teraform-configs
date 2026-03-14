FROM ubuntu:20.04

# Install wine and other dependencies
ENV DEBIAN_FRONTEND=noninteractive
RUN dpkg --add-architecture i386 && \
    apt-get update && \
    apt-get install -y --no-install-recommends \
    wine \
    wine32 \
    python2.7 \
    procps \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /seafile

# Copy the extracted seafile server files
COPY temp_seafile/seafile-server-3.1.4 /seafile/server

# Set up environment variables for Wine if needed
ENV WINEDEBUG=-all

# Standard ccnet-server port
EXPOSE 10001
EXPOSE 8000
EXPOSE 12001

# Start script
RUN echo '#!/bin/sh\n\
export WINEPREFIX=/seafile/wine\n\
wineboot --init\n\
cd /seafile/server/seafile/bin\n\
wine ccnet-server.exe -c /seafile/ccnet -d /seafile/seafile-data\n' > /seafile/start.sh && \
chmod +x /seafile/start.sh

CMD ["/seafile/start.sh"]
