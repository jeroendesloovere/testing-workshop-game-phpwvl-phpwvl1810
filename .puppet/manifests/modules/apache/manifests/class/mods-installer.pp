define apache::class::mods-installer() {

  $activate = "a2enmod ${name}"

  exec { $activate:
    command => $activate,
    require => Package[$apache::params::packages],
    unless => "find /etc/apache2/mods-enabled -print|grep -c ${name}",
    notify => Service[$apache::params::services],
  }
}