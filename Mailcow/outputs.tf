output "mailcow_ui_url" {
  description = "The URL to access Mailcow UI"
  value       = "http://localhost:${var.mailcow_port}"
}
