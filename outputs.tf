output "target_vm_ips" {
  description = "IP addresses of the 10 Target VMs"
  value       = [for vm in docker_container.target_vms : vm.network_data[0].ip_address]
}

output "application_urls" {
  description = "Access URLs for all orchestrated applications"
  value = {
    mailcow     = module.mailcow.mailcow_ui_url
    mailhog     = module.mailhog.mailhog_ui_url
    filerun     = module.filerun.filerun_url
    nextcloud   = module.nextcloud.nextcloud_url
    owncloud    = module.owncloud.owncloud_url
    pydio       = module.pydio.pydio_url
    seafile     = module.seafile.seafile_url
    piwigo      = module.piwigo.piwigo_url
    zenphoto    = module.zenphoto.zenphoto_url
    coppermine  = module.coppermine.coppermine_url
    hmailserver = module.hmailserver.webadmin_url
    nginx       = module.nginx.upload_url
  }
}
