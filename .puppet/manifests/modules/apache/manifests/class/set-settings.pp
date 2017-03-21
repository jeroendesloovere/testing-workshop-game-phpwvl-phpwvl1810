define apache::class::set-settings (
  $config_file = "/etc/apache2/apache2.conf",
) {

  $setting = "${name}"

  exec { $setting:
    command => "echo $setting >> $config_file",
    unless => "grep -c \"$setting\" $config_file",
    require => Package[$apache::params::packages],
    notify => Service[$apache::params::services],
  }

}