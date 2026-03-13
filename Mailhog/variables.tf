variable "mailhog_version" {
  description = "The version of MailHog to deploy"
  default     = "1.0.1"
}

variable "mailhog_image" {
  description = "The Docker image for MailHog"
  default     = "mailhog-local:1.0.1"
}

variable "mailhog_smtp_port" {
  description = "The host port for Mailhog SMTP"
  default     = 1025
}

variable "mailhog_http_port" {
  description = "The host port for Mailhog Web UI"
  default     = 8025
}
