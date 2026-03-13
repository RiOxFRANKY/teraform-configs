variable "network_name" {
  description = "The name of the shared network"
}

# Standalone Nginx to simulate the environment
resource "docker_container" "nginx_controller" {
  name  = "nginx-ingress-controller"
  image = var.nginx_image
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 80
    external = var.upload_port
  }
  restart = "always"
}

# Documentation resource for NGINX-Ingress RCE (CVE-2025-1974)
resource "null_resource" "nginx_rce_documentation" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: INGRESS-NGINX RCE ---"
      echo "CVE: CVE-2025-1974"
      echo "Affected Version: ingress-nginx v4.11.0"
      echo "Mechanism: Injection of 'ssl_engine' directive via Ingress annotations allows loading arbitrary shared objects (/proc/self/fd/X)."
      echo "Exploit Files: exploit.py, shell.c"
    EOT
  }
}
