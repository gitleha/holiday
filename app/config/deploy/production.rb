set :stage,  :production
set :branch, "master"
set :application, "holidays"
set :deploy_to,   "/var/www/html/holidays"

server '172.16.0.25', :app, :web
ssh_options[:port] = "22000"
