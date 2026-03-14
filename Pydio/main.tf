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

resource "docker_container" "pydio" {
  name  = "pydio-cells"
  image = "pydio/cells-enterprise:${var.pydio_version}"
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 8080
    external = var.pydio_port
  }
  env = [
    "CELLS_BIND=0.0.0.0:8080",
    "CELLS_EXTERNAL=localhost:${var.pydio_port}",
    "CELLS_NO_TLS=1",
    "CELLS_DATABASE_DSN=postgres://${var.db_user}:${var.db_password}@postgres-server:5432/pydio?sslmode=disable"
  ]
  restart = "always"
}

# Documentation resource for Pydio Cells XSS via File Download
resource "null_resource" "xss_documentation" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: XSS VIA FILE DOWNLOAD ---"
      echo "CVE: CVE-2023-32751"
      echo "Affected versions: <= 4.1.2"
      echo "Mechanism: Modifying 'response-content-disposition' to 'inline' and 'response-content-type' to 'text/html' allows executing JS in uploaded files."
      echo "Advisory: 51497.txt"
    EOT
  }
}
