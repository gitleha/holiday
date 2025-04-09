# Load DSL and set up stages
require "capistrano/setup"

# Include default deployment tasks
require "capistrano/deploy"

require 'capistrano/composer'
require 'capistrano/symfony'
require 'capistrano/file-permissions'
require 'capistrano/symfony-doctrine'

# Load the SCM plugin appropriate to project:
require "capistrano/scm/git"
install_plugin Capistrano::SCM::Git

# Load custom tasks from `lib/capistrano/tasks` if you have any defined
Dir.glob("lib/capistrano/tasks/*.rake").each { |r| import r }