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

resource "docker_container" "mailcow_ui" {
  name  = "mailcow-server"
  image = var.mailcow_image
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 80
    external = var.mailcow_port
  }
  restart = "always"
}

# Documentation resource for Mailcow CSRF (CVE-2017-8928)
resource "null_resource" "mailcow_vulnerability_documentation" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: MAILCOW CSRF ---"
      echo "Vulnerability: Mailcow 0.14"
      echo "CVE: CVE-2017-8928"
      echo "Issue 1: Admin Password Reset via CSRF."
      echo "Issue 2: Add Arbitrary Admin via CSRF."
      echo "Issue 3: Delete Domains via CSRF."
      echo "Exploit Files: csrf_password_reset.html, csrf_add_admin.html, 42004 (1).txt"
    EOT
  }
}
