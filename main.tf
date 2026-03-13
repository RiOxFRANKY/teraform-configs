terraform {
  required_providers {
    docker = {
      source  = "kreuzwerker/docker"
      version = "~> 3.0.1"
    }
  }
}

provider "docker" {}

resource "docker_network" "lab_internal" {
  name = "lab_internal"
}

# --- 10 Simulated Target VMs ---
resource "docker_container" "target_vms" {
  count = 10
  name  = "target-vm-${count.index + 1}"
  image = "ubuntu:latest"
  command = ["tail", "-f", "/dev/null"] # Keep them running
  networks_advanced {
    name = docker_network.lab_internal.name
  }
}

# --- Module Integrations ---

module "filerun" {
  source       = "./Filerun"
  network_name = docker_network.lab_internal.name
}

module "nginx" {
  source       = "./nginx"
  network_name = docker_network.lab_internal.name
}

module "coppermine" {
  source       = "./Coppermine photo gallery"
  network_name = docker_network.lab_internal.name
}

module "zenphoto" {
  source       = "./Zenphoto"
  network_name = docker_network.lab_internal.name
}

module "piwigo" {
  source       = "./Piwigo"
  network_name = docker_network.lab_internal.name
}

module "hmailserver" {
  source       = "./hmailserver"
  network_name = docker_network.lab_internal.name
}

module "mailhog" {
  source       = "./Mailhog"
  network_name = docker_network.lab_internal.name
}

module "mailcow" {
  source       = "./Mailcow"
  network_name = docker_network.lab_internal.name
}

module "nextcloud" {
  source       = "./Nextcloud"
  network_name = docker_network.lab_internal.name
}

module "owncloud" {
  source       = "./Owncloud"
  network_name = docker_network.lab_internal.name
}

module "pydio" {
  source       = "./Pydio"
  network_name = docker_network.lab_internal.name
}

module "seafile" {
  source       = "./Seafile"
  network_name = docker_network.lab_internal.name
}
