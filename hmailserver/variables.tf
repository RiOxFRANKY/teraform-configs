variable "hmail_version" {
  description = "The version of hMailServer to deploy"
  default     = "4.4.2"
}

variable "hmail_image" {
  description = "The Docker image for hMailServer (PHPWebAdmin simulation)"
  default     = "hmailserver-webadmin:4.4.2"
}

variable "webadmin_port" {
  description = "The host port for hMailServer PHPWebAdmin"
  default     = 8087
}
