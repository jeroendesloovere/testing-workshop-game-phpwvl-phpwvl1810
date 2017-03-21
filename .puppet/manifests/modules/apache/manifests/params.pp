class apache::params {

  $packages = [
    "apache2",
    "apache2-mpm-prefork",
    "libapache2-mod-php5",
  ]

  $modules = [
    "env",
    "headers",
    "deflate",
    "expires",
    "rewrite",
    "ssl",
  ]

  $services = [
    "apache2",
  ]

  $settings = [
    "ServerTokens Prod",
    "ServerSignature Off",
    "ServerName in2devbox",
  ]

  $vhosts = [
    "theialive",
  ]
}