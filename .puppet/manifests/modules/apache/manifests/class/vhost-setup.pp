define apache::class::vhost-setup (
  $host = "*",
  $port = 80,
  $applicationEnv = "development"
) {

  # Global settings
  $config = "${name}.conf"
  $path = "/etc/apache2/sites-available/${config}"
  $activate = "a2ensite ${config}"
  $serverName = "${name}.local"
  $serverAlias = "www.${serverName}"
  $projectRoot = "/var/www/${serverName}"
  $documentRoot = "${projectRoot}/public"

  file { $projectRoot:
    ensure => link,
    target => "/vagrant",
    require => Package[$apache::params::packages],
    notify => Service[$apache::params::services],
  }

  file { $config:
    path => $path,
    ensure => file,
    content => template("apache/vhost.conf.erb"),
    require => Package[$apache::params::packages],
    notify => Exec[$activate],
  }

  exec { $activate:
    command => $activate,
    unless => "find /etc/apache2/sites-enabled | grep -c ${config}",
    require => File[$config],
    notify => Service[$apache::params::services],
  }

  # disable default web site
  exec { "a2dissite 000-default":
    command => "a2dissite 000-default",
    onlyif => "find /etc/apache2/site-enabled | grep -c 000-default",
    require => Package[$apache::params::packages],
    notify => Service[$apache::params::services],
  }

}