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

resource "docker_container" "mailhog" {
  name  = "mailhog-server"
  image = var.mailhog_image
  networks_advanced {
    name = var.network_name
  }
  ports {
    internal = 8025
    external = var.mailhog_http_port
  }
  ports {
    internal = 1025
    external = var.mailhog_smtp_port
  }
  restart = "always"
}

# Documentation resource for Mailhog Stored XSS
resource "null_resource" "mailhog_xss_documentation" {
  provisioner "local-exec" {
    command = <<EOT
      echo "--- RESEARCH NOTE: MAILHOG STORED XSS ---"
      echo "Vulnerability: Mailhog 1.0.1"
      echo "Problem: CSRF and unrestricted API calls lead to Stored XSS via malicious attachments."
      echo "Impact: API calls (email deletion, sending, reading) can be executed in the context of the victim's session."
      echo "Exploit Files: xss_payload.html, 50971.txt"
    EOT
  }
}
