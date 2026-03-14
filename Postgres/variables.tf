variable "postgres_version" {
  description = "The version of PostgreSQL to deploy"
  default     = "15-alpine"
}

variable "postgres_port" {
  description = "The host port for PostgreSQL"
  default     = 5432
}

variable "db_password" {
  description = "Database password for PostgreSQL"
  default     = "research_pass"
  sensitive   = true
}

variable "db_user" {
  description = "Database user for PostgreSQL"
  default     = "postgres"
}

variable "db_name" {
  description = "Database name for PostgreSQL"
  default     = "lab_db"
}

variable "network_name" {
  description = "The name of the shared network"
}
