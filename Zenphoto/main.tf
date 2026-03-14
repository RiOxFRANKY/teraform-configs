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

resource "docker_container" "zenphoto" {
  name  = "zenphoto-gallery"
  # Using a representative PHP-Apache image for legacy 1.4.4
  # In a real lab, this would use a custom image: zenphoto:1.4.4
  image = var.zenphoto_image 
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 80
    external = var.zenphoto_port
  }
  env = [
    "ZP_DB_TYPE=postgresql",
    "ZP_DB_HOST=postgres-server",
    "ZP_DB_NAME=zenphoto",
    "ZP_DB_USER=${var.db_user}",
    "ZP_DB_PASS=${var.db_password}"
  ]
  restart = "always"
}

# Documentation resource for Zenphoto SQL Injection
resource "null_resource" "sql_injection_documentation" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: SQL INJECTION IN ZENPHOTO ---"
      echo "Vulnerability: ZenPhoto 1.4.4"
      echo "CVE/BID: BID 65126"
      echo "Mechanism: SQL Injection via the 'date' parameter in index.php."
      echo "Endpoint: /zenphoto/index.php?p=search&date=[SQL_Injection]"
      echo "Advisory: 39062.txt"
    EOT
  }
}
