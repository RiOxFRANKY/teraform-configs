terraform {
  required_providers {
    docker = {
      source  = "kreuzwerker/docker"
      version = ">= 3.0.0"
    }
  }
}

provider "docker" {
  host = "npipe:////./pipe/dockerDesktopLinuxEngine"
}

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
  db_user      = var.db_user
  db_password  = var.db_password
  depends_on   = [docker_container.mariadb]
}

module "nginx" {
  source       = "./nginx"
  network_name = docker_network.lab_internal.name
}

module "coppermine" {
  source       = "./Coppermine photo gallery"
  network_name = docker_network.lab_internal.name
  db_user      = var.db_user
  db_password  = var.db_password
  depends_on   = [docker_container.mariadb]
}

module "zenphoto" {
  source       = "./Zenphoto"
  network_name = docker_network.lab_internal.name
  db_user      = var.db_user
  db_password  = var.db_password
  depends_on   = [module.postgres]
}

module "piwigo" {
  source       = "./Piwigo"
  network_name = docker_network.lab_internal.name
  db_user      = var.db_user
  db_password  = var.db_password
  depends_on   = [docker_container.mariadb]
}

module "hmailserver" {
  source       = "./hmailserver"
  network_name = docker_network.lab_internal.name
  db_user      = var.db_user
  db_password  = var.db_password
  depends_on   = [docker_container.mariadb]
}

module "mailhog" {
  source       = "./Mailhog"
  network_name = docker_network.lab_internal.name
}

module "mailcow" {
  source       = "./Mailcow"
  network_name = docker_network.lab_internal.name
  db_user      = var.db_user
  db_password  = var.db_password
  depends_on   = [module.postgres]
}

module "nextcloud" {
  source       = "./Nextcloud"
  network_name = docker_network.lab_internal.name
  db_user      = var.db_user
  db_password  = var.db_password
  depends_on   = [module.postgres]
}

module "owncloud" {
  source       = "./Owncloud"
  network_name = docker_network.lab_internal.name
  db_user      = var.db_user
  db_password  = var.db_password
  depends_on   = [module.postgres]
}

module "pydio" {
  source       = "./Pydio"
  network_name = docker_network.lab_internal.name
  db_user      = var.db_user
  db_password  = var.db_password
  depends_on   = [module.postgres]
}

module "seafile" {
  source       = "./Seafile"
  network_name = docker_network.lab_internal.name
  db_user      = var.db_user
  db_password  = var.db_password
  depends_on   = [module.postgres]
}

module "postgres" {
  source       = "./Postgres"
  network_name = docker_network.lab_internal.name
  db_user      = var.db_user
  db_password  = var.db_password
}

resource "docker_container" "redis" {
  name  = "redis-mailcow"
  image = "redis:7-alpine"
  networks_advanced {
    name = docker_network.lab_internal.name
  }
  restart = "always"
}

resource "docker_container" "mariadb" {
  name  = "mariadb-server"
  image = "mariadb:10.5"
  networks_advanced {
    name = docker_network.lab_internal.name
  }
  env = [
    "MYSQL_ROOT_PASSWORD=${var.db_password}",
    "MYSQL_DATABASE=lab_db",
    "MYSQL_USER=${var.db_user}",
    "MYSQL_PASSWORD=${var.db_password}"
  ]
  ports {
    internal = 3306
    external = 3306
  }
  restart = "always"
}
