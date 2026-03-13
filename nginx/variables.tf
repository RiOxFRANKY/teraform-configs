variable "nginx_ingress_version" {
  description = "The version of Ingress-NGINX to deploy"
  default     = "4.11.0"
}

variable "nginx_image" {
  description = "The Docker image for Ingress-NGINX"
  default     = "ingress-nginx-local:4.11.0"
}

variable "upload_port" {
  description = "Port to simulate the target upload service"
  default     = 8083
}

variable "admission_port" {
  description = "Port to simulate the Kubernetes Admission Controller"
  default     = 8443
}
