output "piwigo_url" {
  description = "The URL to access Piwigo"
  value       = "http://localhost:${var.piwigo_port}"
}

output "db_container_name" {
  description = "The name of the database container"
  value       = docker_container.db.name
}
