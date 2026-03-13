variable "zenphoto_version" {
  description = "The version of Zenphoto to deploy"
  default     = "1.4.3.3"
}

variable "zenphoto_image" {
  description = "The Docker image for Zenphoto"
  default     = "zenphoto-local:1.4.3.3"
}

variable "zenphoto_port" {
  description = "The host port for Zenphoto"
  default     = 8085
}

variable "db_password" {
  description = "Database password for Zenphoto"
  default     = "research_pass"
  sensitive   = true
}

variable "db_user" {
  description = "Database user for Zenphoto"
  default     = "zenphoto"
}

variable "db_name" {
  description = "Database name for Zenphoto"
  default     = "zenphoto_db"
}
