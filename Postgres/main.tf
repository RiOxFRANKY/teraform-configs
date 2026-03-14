terraform {
  required_providers {
    docker = {
      source  = "kreuzwerker/docker"
      version = ">= 3.0.0"
    }
  }
}

resource "docker_container" "postgres_db" {
  name  = "postgres-server"
  image = "postgres:${var.postgres_version}"
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 5432
    external = var.postgres_port
  }
  env = [
    "POSTGRES_PASSWORD=${var.db_password}",
    "POSTGRES_DB=${var.db_name}",
    "POSTGRES_USER=${var.db_user}"
  ]
  volumes {
    host_path      = abspath("${path.module}/init-db.sh")
    container_path = "/docker-entrypoint-initdb.d/init-db.sh"
  }
  restart = "always"
}

# Documentation resource for PostgreSQL Security (Educational)
resource "null_resource" "postgres_security_notes" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: POSTGRESQL SECURITY ---"
      echo "Note: Ensure the PostgreSQL container is only accessible via the internal lab network."
      echo "Best Practice: Use environment variables for sensitive credentials (implemented)."
      echo "Vulnerability Research: Monitor for CVEs related to auth bypass or SQL injection in specific versions."
    EOT
  }
}
