output "filerun_url" {
  description = "The URL to access Filerun"
  value       = "http://localhost:${var.filerun_port}"
}

output "db_container_name" {
  description = "The name of the database container"
  value       = docker_container.db.name
}
