output "coppermine_url" {
  description = "The URL to access Coppermine Photo Gallery"
  value       = "http://localhost:${var.coppermine_port}"
}

output "db_container_name" {
  description = "The name of the database container"
  value       = docker_container.db.name
}
