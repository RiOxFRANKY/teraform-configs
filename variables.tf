variable "db_user" {
  description = "The database administrative user"
  type        = string
  default     = "postgres"
}

variable "db_password" {
  description = "The database administrative password"
  type        = string
  default     = "research_pass"
  sensitive   = true
}

variable "db_name" {
  description = "The default database name"
  type        = string
  default     = "lab_db"
}
