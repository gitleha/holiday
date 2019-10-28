# Configure required variables for Symfony2 deployment
set :deploy_config_path, 'etc/deploy.rb'
set :stage_config_path,  'etc/deploy'

# Load DSL and set up stages
require "capistrano/setup"

# Include default deployment tasks
require "capistrano/deploy"

require 'capistrano/composer'
require 'capistrano/symfony'
require 'capistrano/file-permissions'
require 'capistrano/symfony-doctrine'