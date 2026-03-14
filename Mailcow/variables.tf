variable "mailcow_version" {
  description = "The version of Mailcow to deploy"
  default     = "0.14"
}

variable "mailcow_image" {
  description = "The Docker image for Mailcow"
  default     = "mailcow-local:0.14"
}

variable "mailcow_port" {
  description = "The host port for Mailcow UI"
  default     = 8088
}

variable "db_user" {
  description = "Database user for Mailcow"
}

variable "db_password" {
  description = "Database password for Mailcow"
  sensitive   = true
}
