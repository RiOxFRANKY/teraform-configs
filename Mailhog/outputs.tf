output "mailhog_ui_url" {
  description = "The URL to access Mailhog Web UI"
  value       = "http://localhost:${var.mailhog_http_port}"
}

output "mailhog_smtp_endpoint" {
  description = "The endpoint for Mailhog SMTP"
  value       = "localhost:${var.mailhog_smtp_port}"
}
