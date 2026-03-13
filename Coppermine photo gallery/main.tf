variable "network_name" {
  description = "The name of the shared network"
}

resource "docker_container" "db" {
  name  = "coppermine-db"
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

resource "docker_container" "coppermine" {
  name  = "coppermine-gallery"
  image = var.coppermine_image
  networks_advanced {
    name = docker_network.coppermine_net.name
  }
  ports {
    internal = 80
    external = var.coppermine_port
  }
  restart = "always"
  depends_on = [docker_container.db]
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
