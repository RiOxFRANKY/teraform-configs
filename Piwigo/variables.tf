variable "piwigo_version" {
  description = "The version of Piwigo to deploy"
  default     = "2.5.3"
}

variable "piwigo_image" {
  description = "The Docker image for Piwigo"
  default     = "piwigo-local:2.5.3"
}

variable "piwigo_port" {
  description = "The host port for Piwigo"
  default     = 8086
}

variable "db_password" {
  description = "Database password for Piwigo"
  default     = "research_pass"
  sensitive   = true
}

variable "db_user" {
  description = "Database user for Piwigo"
  default     = "piwigo"
}

variable "db_name" {
  description = "Database name for Piwigo"
  default     = "piwigo_db"
}
