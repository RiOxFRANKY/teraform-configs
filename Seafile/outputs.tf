output "seafile_url" {
  description = "The URL to access Seafile Seahub"
  value       = "http://localhost:${var.seafile_port}"
}

output "ccnet_endpoint" {
  description = "The endpoint for Seafile CCnet service (Vulnerable Port)"
  value       = "localhost:${var.ccnet_port}"
}

