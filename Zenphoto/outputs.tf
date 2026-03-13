output "zenphoto_url" {
  description = "The URL to access Zenphoto"
  value       = "http://localhost:${var.zenphoto_port}"
}

output "db_container_name" {
  description = "The name of the database container"
  value       = docker_container.db.name
}
