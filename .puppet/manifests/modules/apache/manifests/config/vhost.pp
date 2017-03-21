class apache::config::vhost {

  apache::class::vhost-setup { $apache::params::vhosts: }

}