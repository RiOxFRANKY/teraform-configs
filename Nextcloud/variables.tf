variable "nextcloud_version" {
  description = "The version of Nextcloud to deploy"
  default     = "17.0.0-apache"
}

variable "nextcloud_port" {
  description = "The host port for Nextcloud"
  default     = 8080
}

variable "db_password" {
  description = "Database password for Nextcloud"
  default     = "research_pass"
  sensitive   = true
}

variable "db_user" {
  description = "Database user for Nextcloud"
  default     = "nextcloud"
}

variable "db_name" {
  description = "Database name for Nextcloud"
  default     = "nextcloud"
}
