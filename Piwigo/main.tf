terraform {
  required_providers {
    docker = {
      source  = "kreuzwerker/docker"
      version = "~> 3.0.1"
    }
  }
}

variable "network_name" {
  description = "The name of the shared network"
}

resource "docker_container" "db" {
  name  = "piwigo-db"
  image = "mariadb:10.5"
  networks_advanced {
    name = var.network_name
  }
  env = [
    "MYSQL_ROOT_PASSWORD=${var.db_password}",
    "MYSQL_PASSWORD=${var.db_password}",
    "MYSQL_DATABASE=${var.db_name}",
    "MYSQL_USER=${var.db_user}"
  ]
  restart = "always"
}

resource "docker_container" "piwigo" {
  name  = "piwigo-server"
  # Using a representative PHP-Apache image for legacy 2.5.3
  # In a real lab, this would use a custom image: piwigo:2.5.3
  image = var.piwigo_image
  networks_advanced {
    name = docker_network.piwigo_net.name
  }
  ports {
    internal = 80
    external = var.piwigo_port
  }
  restart = "always"
  depends_on = [docker_container.db]
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
