class apache::install::package {

  package { $apache::params::packages:
    ensure => latest,
    provider => apt,
    notify => Service[$apache::params::services],
  }

  if $require {
    Package[$apache::params::packages] {
      require +> $require
    }
  }

  service { $apache::params::services:
    ensure => "running",
    enable => true,
  }
}