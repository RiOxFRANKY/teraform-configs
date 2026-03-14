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

resource "docker_container" "coppermine" {
  name  = "coppermine-gallery"
  image = var.coppermine_image
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 80
    external = var.coppermine_port
  }
  env = [
    "DB_TYPE=mysql",
    "DB_HOST=mariadb-server",
    "DB_USER=${var.db_user}",
    "DB_PASSWORD=${var.db_password}",
    "DB_NAME=coppermine"
  ]
  restart = "always"
}

# Documentation resource for Coppermine Photo Gallery SQL Injection
resource "null_resource" "sql_injection_documentation" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: SQL INJECTION IN COPPERMINE ---"
      echo "Vulnerability: Coppermine Photo Gallery <= 1.4.10"
      echo "Mechanism: Lack of sanitization in SQL queries leads to SQL Injection."
      echo "Affected Files: usermgr.php, db_ecard.php, albmgr.php"
      echo "Exploit File: 29397.php"
    EOT
  }
}
