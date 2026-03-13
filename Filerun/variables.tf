variable "filerun_version" {
  description = "The version of Filerun to deploy"
  default     = "2021.03.26"
}

variable "filerun_image" {
  description = "The Docker image for Filerun"
  default     = "filerun-local:2021.03.26"
}

variable "filerun_port" {
  description = "The host port for Filerun"
  default     = 8082
}

variable "db_password" {
  description = "Database password for Filerun"
  default     = "research_pass"
  sensitive   = true
}

variable "db_user" {
  description = "Database user for Filerun"
  default     = "filerun"
}

variable "db_name" {
  description = "Database name for Filerun"
  default     = "filerun_db"
}
