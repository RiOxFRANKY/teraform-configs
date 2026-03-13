variable "pydio_version" {
  description = "The version of Pydio Cells to deploy"
  default     = "4.1"
}

variable "pydio_port" {
  description = "The host port for Pydio Cells"
  default     = 8081
}

variable "db_password" {
  description = "Database password for Pydio"
  default     = "research_pass"
  sensitive   = true
}

variable "db_user" {
  description = "Database user for Pydio"
  default     = "pydio"
}

variable "db_name" {
  description = "Database name for Pydio"
  default     = "cells"
}
