variable "network_name" {
  description = "The name of the shared network"
}

resource "docker_container" "db" {
  name  = "zenphoto-db"
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

resource "docker_container" "zenphoto" {
  name  = "zenphoto-gallery"
  # Using a representative PHP-Apache image for legacy 1.4.4
  # In a real lab, this would use a custom image: zenphoto:1.4.4
  image = var.zenphoto_image 
  networks_advanced {
    name = docker_network.zenphoto_net.name
  }
  ports {
    internal = 80
    external = var.zenphoto_port
  }
  restart = "always"
  depends_on = [docker_container.db]
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
