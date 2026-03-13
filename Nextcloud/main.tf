variable "network_name" {
  description = "The name of the shared network"
}

resource "docker_container" "db" {
  name  = "nextcloud-db"
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

resource "docker_container" "nextcloud" {
  name  = "nextcloud-server"
  image = "partitio/nextcloud:${var.nextcloud_version}"
  networks_advanced {
    name = docker_network.nextcloud_net.name
  }
  ports {
    internal = 9000 # Standard FPM port
    external = var.nextcloud_port
  }
  env = [
    "MYSQL_PASSWORD=${var.db_password}",
    "MYSQL_DATABASE=${var.db_name}",
    "MYSQL_USER=${var.db_user}",
    "MYSQL_HOST=nextcloud-db"
  ]
  restart = "always"
  depends_on = [docker_container.db]
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
