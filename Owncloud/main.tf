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

resource "docker_container" "db" {
  name  = "owncloud-db"
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

resource "docker_container" "owncloud" {
  name  = "owncloud-server"
  image = "vulhub/owncloud:${var.owncloud_version}" # Using vulhub image for vulnerability research
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 8080
    external = var.owncloud_port
  }
  env = [
    "OWNCLOUD_DB_TYPE=mysql",
    "OWNCLOUD_DB_NAME=${var.db_name}",
    "OWNCLOUD_DB_USER=${var.db_user}",
    "OWNCLOUD_DB_PASSWORD=${var.db_password}",
    "OWNCLOUD_DB_HOST=owncloud-db",
    "OWNCLOUD_ADMIN_USERNAME=admin",
    "OWNCLOUD_ADMIN_PASSWORD=admin"
  ]
  restart = "always"
  depends_on = [docker_container.db]
}

# Documentation resource for major ownCloud vulnerabilities
resource "null_resource" "vulnerability_documentation" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: CRITICAL OWNCLOUD VULNERABILITIES (v10.12.1) ---"
      echo "CVE-2023-49105: WebDAV API Authentication Bypass (CVSS 9.8)"
      echo "Mechanism: Accepts pre-signed URLs if no signing key is configured for the file owner."
      echo "Impact: Unauthenticated access, modification, or deletion of any file."
      echo ""
      echo "CVE-2023-49103: Graph API Information Disclosure (CVSS 10.0)"
      echo "Mechanism: Exposure of phpinfo() via graphapi app."
      echo "Impact: Disclosure of sensitive environment variables, including admin passwords and credentials."
    EOT
  }
}
