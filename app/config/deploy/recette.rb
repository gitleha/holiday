set :stage, :recette
set :branch, "master"
set :application, "holidays"
set :deploy_to,   "/var/www/html/holidays"

server 'oweb100t:22', user: 'root'
server 'oweb101t:22', user: 'root'
