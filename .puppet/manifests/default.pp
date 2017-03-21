File {
  owner => "root",
  group => "root",
  mode => "0644",
}

Exec {
  path => ["/bin", "/usr/bin", "/usr/sbin", "/usr/local/bin"]
}

exec { "apt-update":
  command => "apt-get update",
}

include apache
include php