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

resource "docker_container" "nextcloud" {
  name  = "nextcloud-server"
  image = "nextcloud:${var.nextcloud_version}"
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 80
    external = var.nextcloud_port
  }
  env = [
    "POSTGRES_PASSWORD=${var.db_password}",
    "POSTGRES_DB=nextcloud",
    "POSTGRES_USER=${var.db_user}",
    "POSTGRES_HOST=postgres-server"
  ]
  restart = "always"
}

# Example of documenting the internal OCS API call structure found in research
# This is a template for educational purposes within the research lab environment.
resource "null_resource" "csrf_documentation" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: VULNERABLE ENDPOINT IDENTIFIED ---"
      echo "Endpoint: /ocs/v2.php/cloud/users"
      echo "Method: POST"
      echo "Payload Sample: {\"userid\":\"test_research\",\"password\":\"test1234\"}"
      echo "Note: Nextcloud 17 vulnerability lacks proper CSRF token validation on certain OCS endpoints."
    EOT
  }
}
