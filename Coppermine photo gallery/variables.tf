variable "coppermine_version" {
  description = "The version of Coppermine Photo Gallery to deploy"
  default     = "1.4.11"
}

variable "coppermine_image" {
  description = "The Docker image for Coppermine Photo Gallery"
  default     = "coppermine-local:1.4.11"
}

variable "coppermine_port" {
  description = "The host port for Coppermine Photo Gallery"
  default     = 8084
}

variable "db_password" {
  description = "Database password for Coppermine"
  default     = "research_pass"
  sensitive   = true
}

variable "db_user" {
  description = "Database user for Coppermine"
  default     = "coppermine"
}

variable "db_name" {
  description = "Database name for Coppermine"
  default     = "cpg_db"
}
