output "nextcloud_url" {
  value       = "http://localhost:${var.nextcloud_port}"
  description = "The URL to access the vulnerable Nextcloud 17 instance"
}

output "research_api_test" {
  value = "curl -X POST -H 'requesttoken: <TOKEN_WOULD_BE_MISSING_OR_BYPASSED>' -H 'Content-Type: application/json' -d '{\"userid\":\"test_research\",\"password\":\"test1234\", \"groups\":[]}' http://localhost:${var.nextcloud_port}/ocs/v2.php/cloud/users"
  description = "Sample CURL command mimicking the CSRF vulnerable API call for research verification."
}
