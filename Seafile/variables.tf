variable "seafile_version" {
  description = "The version of Seafile to deploy"
  default     = "3.1.4"
}

variable "seafile_image" {
  description = "The Docker image for Seafile"
  default     = "seafile-local:3.1.4"
}

variable "seafile_port" {
  description = "The host port for Seafile Seahub"
  default     = 8000
}

variable "ccnet_port" {
  description = "The host port for Seafile CCnet"
  default     = 10001
}

variable "db_password" {
  description = "Database password for Seafile"
  default     = "research_pass"
  sensitive   = true
}

variable "db_user" {
  description = "Database user for Seafile"
  default     = "seafile"
}

variable "db_name" {
  description = "Database name for Seafile"
  default     = "seafile_db"
}
