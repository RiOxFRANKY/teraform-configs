variable "owncloud_version" {
  description = "The version of ownCloud to deploy"
  default     = "10.12.1"
}

variable "owncloud_port" {
  description = "The host port for ownCloud"
  default     = 8081
}

variable "db_password" {
  description = "Database password for ownCloud"
  default     = "research_pass_own"
  sensitive   = true
}

variable "db_user" {
  description = "Database user for ownCloud"
  default     = "owncloud"
}

variable "db_name" {
  description = "Database name for ownCloud"
  default     = "owncloud"
}
