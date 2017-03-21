class php::install::package {

  package { $php::params::packages:
    ensure => latest,
    notify => Service[$apache::params::services],
  }

}