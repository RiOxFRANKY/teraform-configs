output "webadmin_url" {
  description = "The URL to access hMailServer PHPWebAdmin"
  value       = "http://localhost:${var.webadmin_port}"
}
