# server-based syntax
# ======================
# Defines a single server with a list of roles and multiple properties.
# You can define all roles on a single server, or split them:

server 'otools01:22', user: 'root'
server 'otools02:22', user: 'root'

set :stage, :recette
set :branch, "dev"
set :symfony_env, "prod"