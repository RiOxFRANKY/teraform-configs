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

resource "docker_container" "piwigo" {
  name  = "piwigo-server"
  # Using a representative PHP-Apache image for legacy 2.5.3
  # In a real lab, this would use a custom image: piwigo:2.5.3
  image = var.piwigo_image
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 80
    external = var.piwigo_port
  }
  env = [
    "POSTGRES_DB=piwigo",
    "POSTGRES_USER=${var.db_user}",
    "POSTGRES_PASSWORD=${var.db_password}",
    "POSTGRES_HOST=postgres-server"
  ]
  restart = "always"
}

# Documentation resource for Piwigo Stored XSS and CSRF
resource "null_resource" "piwigo_vulnerability_documentation" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: PIWIGO STORED XSS & CSRF ---"
      echo "Vulnerability: Piwigo 2.5.3 CMS"
      echo "Issue 1: Stored XSS on multiple parameters (Album Name, Group Name)."
      echo "Issue 2: CSRF in 'add a user' functionality (/admin.php?page=user_list)."
      echo "Exploit Files: csrf_poc.html, 30310.txt"
    EOT
  }
}
