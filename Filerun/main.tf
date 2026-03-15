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

resource "docker_container" "filerun" {
  name  = "filerun-server"
  image = var.filerun_image
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 80
    external = var.filerun_port
  }
  env = [
    "FR_DB_TYPE=mysql",
    "FR_DB_HOST=mysql-server",
    "FR_DB_PORT=3306",
    "FR_DB_NAME=filerun",
    "FR_DB_USER=${var.db_user}",
    "FR_DB_PASS=${var.db_password}"
  ]
  restart = "always"
}

# Documentation resource for Filerun Authenticated RCE (XSS chain)
resource "null_resource" "rce_documentation" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: AUTHENTICATED RCE VIA XSS CHAIN ---"
      echo "Exploit Title: Filerun 2021.03.26 - Remote Code Execution (RCE) (Authenticated)"
      echo "CVE: N/A (Authenticated RCE)"
      echo "Mechanism: Chaining a stored XSS (via X-Forwarded-For) with an insecure 'convert' command execution in the admin panel."
      echo "Exploit File: 50313.py"
    EOT
  }
}
