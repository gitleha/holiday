set :stage,  :production
set :branch, "master"
set :application, "holidays"
set :deploy_to,   "/var/www/html/holidays"

server '172.16.0.62', :app, :web, :primary => true
server '172.16.0.72', :app, :web

ssh_options[:port] = "22000"
