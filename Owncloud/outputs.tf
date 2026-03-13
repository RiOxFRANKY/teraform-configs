output "owncloud_url" {
  value       = "http://localhost:${var.owncloud_port}"
  description = "The URL to access the ownCloud instance"
}

output "rce_exploit_structure" {
  value = "Upload payload with filename: .htaccess::$DATA"
  description = "The specific filename used to bypass blacklist validation on vulnerable Windows ownCloud versions."
}
