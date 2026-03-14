terraform {
  required_providers {
    docker = {
      source  = "kreuzwerker/docker"
      version = ">= 3.0.0"
    }
  }
}

variable "network_name" {
  description = "The name of the shared network"
}

resource "docker_container" "seafile" {
  name  = "seafile-server"
  image = var.seafile_image
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 8000
    external = var.seafile_port
  }
  ports {
    internal = 10001
    external = var.ccnet_port
  }
  env = [
    "SEAFILE_SERVER_HOSTNAME=seafile.local",
    "SEAFILE_ADMIN_EMAIL=admin@seafile.local",
    "SEAFILE_ADMIN_PASSWORD=admin",
    "DB_TYPE=pgsql",
    "DB_HOST=postgres-server",
    "DB_USER=${var.db_user}",
    "DB_PASSWORD=${var.db_password}",
    "DB_NAME=seafile"
  ]
  restart = "always"
}

# Documentation resource for the ccnet-server remote DoS (assert)
resource "null_resource" "dos_documentation" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: CCNET-SERVER REMOTE DOS (ASSERT) ---"
      echo "Vulnerability: Seafile Server <= 3.1.5"
      echo "Component: ccnet-server"
      echo "Mechanism: Sending a malformed packet to port 10001 triggers an assertion failure."
      echo "Exploit File: 34729.py"
    EOT
  }
}
