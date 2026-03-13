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

resource "docker_container" "hmailserver" {
  name  = "hmailserver-web"
  image = var.hmail_image # Representative image for legacy PHP 5.2 as per advisory
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 80
    external = var.webadmin_port
  }
  restart = "always"
}

# Documentation resource for hMailServer PHPWebAdmin LFI/RFI
resource "null_resource" "hmail_vulnerability_documentation" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: HMAILSERVER PHPWEBADMIN LFI/RFI ---"
      echo "Vulnerability: hMailServer 4.4.2 (PHPWebAdmin)"
      echo "Issue 1: LFI in index.php via 'page' parameter."
      echo "Issue 2: RFI in initialize.php via 'hmail_config[includepath]' (requires register_globals=on)."
      echo "Advisory: 7012.txt"
    EOT
  }
}
