class apache::config {

  include apache::params
  include apache::config::vhost
  include apache::config::mods
  include apache::config::settings

}