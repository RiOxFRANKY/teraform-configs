variable "network_name" {
  description = "The name of the shared network"
}

resource "docker_container" "db" {
  name  = "pydio-db"
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

resource "docker_container" "pydio" {
  name  = "pydio-cells"
  image = "pydio/cells-enterprise:${var.pydio_version}"
  networks_advanced {
    name = docker_network.pydio_net.name
  }
  ports {
    internal = 8080
    external = var.pydio_port
  }
  env = [
    "CELLS_BIND=0.0.0.0:8080",
    "CELLS_EXTERNAL=localhost:${var.pydio_port}",
    "CELLS_NO_TLS=1",
    "CELLS_DATABASE_DSN=${var.db_user}:${var.db_password}@tcp(pydio-db:3306)/${var.db_name}"
  ]
  restart = "always"
  depends_on = [docker_container.db]
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
