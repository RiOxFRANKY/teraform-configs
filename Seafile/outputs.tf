output "seafile_url" {
  description = "The URL to access Seafile Seahub"
  value       = "http://localhost:${var.seafile_port}"
}

output "ccnet_endpoint" {
  description = "The endpoint for Seafile CCnet service (Vulnerable Port)"
  value       = "localhost:${var.ccnet_port}"
}

output "db_container_name" {
  description = "The name of the database container"
  value       = docker_container.db.name
}
