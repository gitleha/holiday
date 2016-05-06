set :stages,        %w(production)
set :default_stage, "production"
set :stage_dir,     "app/config"
require 'capistrano/ext/multistage'

set :deploy_to,   "/var/www/html/holidays"
set :application, "holidays"

set :app_path,    "app"

set :repository, "git@github.com:gitleha/holiday.git"
set :scm, :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`
set :deploy_via, :copy

set :model_manager, "doctrine"
# Or: `propel`


set :keep_releases, 3
set :shared_files, ["app/config/parameters.yml"]
set :writable_dirs, ["var/cache", "var/logs"]
set :webserver_user, "apache"
set :permission_method, :acl
set :use_set_permissions, true

set :use_sudo, false
set :user, "root"
set :use_composer, true
# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

after "deploy" do
	run "cd #{current_path} && php bin/console assetic:dump --env=prod"
end

after "deploy", "deploy:cleanup"
