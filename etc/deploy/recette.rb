server 'rotools:22', user: 'root'

set :stage, :recette
set :branch, "dev"
set :deploy_to,   "/var/www/html/holiday"
set :application, "holiday"
set :symfony_env, "prod"

