output "pydio_url" {
  description = "The URL to access Pydio Cells"
  value       = "http://localhost:${var.pydio_port}"
}

output "db_container_name" {
  description = "The name of the database container"
  value       = docker_container.db.name
}
