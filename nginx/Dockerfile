FROM nginx:latest

# Install tools for research
RUN apt-get update && apt-get install -y \
    python3 \
    python3-pip \
    python3-requests \
    curl \
    gcc \
    libc6-dev \
    && rm -rf /var/lib/apt/lists/*

# Create directory for ingress-nginx files
WORKDIR /opt/ingress-nginx

# Copy the extracted helm chart files
COPY temp_nginx/ingress-nginx /opt/ingress-nginx

# Expose ports for research (simulating webhook and service)
EXPOSE 80
EXPOSE 8443
EXPOSE 10254

CMD ["nginx", "-g", "daemon off;"]
