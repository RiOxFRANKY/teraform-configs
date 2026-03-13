output "upload_url" {
  description = "The URL to simulate shell.so upload"
  value       = "http://localhost:${var.upload_port}"
}

output "admission_url" {
  description = "The URL to simulate AdmissionRequest"
  value       = "https://localhost:${var.admission_port}"
}
