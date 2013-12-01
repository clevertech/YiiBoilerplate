Vagrant.configure("2") do |config|

  config.vm.box = "precise64"
  config.vm.box_url = "http://files.vagrantup.com/precise64.box"

  config.vm.provision :shell, :path => "carcass/vagrant/prepare-precise64.sh"
  config.vm.provision :shell, :path => "carcass/vagrant/setup-app.sh"

  config.vm.network "forwarded_port", guest: 80, host: 8080 # frontend
  config.vm.network "forwarded_port", guest: 81, host: 8081 # backend

end

