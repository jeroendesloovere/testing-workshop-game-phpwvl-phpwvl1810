# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  config.vm.box = "ubuntu/trusty64"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine and only allow access
  # via 127.0.0.1 to disable public access
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder ".", "/var/www/theialive", owner: "www-data", group: "www-data"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  # config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
  #   # Customize the amount of memory on the VM:
  #   vb.memory = "1024"
  # end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get install -y \
      python-software-properties \
      language-pack-en
    locale-gen en_US.UTF-8
    LC_ALL=en_US.UTF-8 add-apt-repository -y ppa:ondrej/php
    apt-get update
    apt-get install -y \
      apache2 \
      php5.6 \
      php5.6-bcmath \
      php5.6-bz2 \
      php5.6-cgi \
      php5.6-cli \
      php5.6-common \
      php5.6-curl \
      php5.6-dba \
      php5.6-dev \
      php5.6-enchant \
      php5.6-fpm \
      php5.6-gd \
      php5.6-gmp \
      php5.6-imap \
      php5.6-interbase \
      php5.6-intl \
      php5.6-json \
      php5.6-ldap \
      php5.6-mbstring \
      php5.6-mcrypt \
      php5.6-mysql \
      php5.6-odbc \
      php5.6-opcache \
      php5.6-pgsql \
      php5.6-phpdbg \
      php5.6-pspell \
      php5.6-readline \
      php5.6-recode \
      php5.6-snmp \
      php5.6-soap \
      php5.6-sqlite3 \
      php5.6-sybase \
      php5.6-tidy \
      php5.6-xml \
      php5.6-xmlrpc \
      php5.6-xsl \
      php5.6-zip \
      libapache2-mod-php5 \
      memcached \
      redis-server \
      redis-tools
    apt-get autoremove -y
  SHELL
end
