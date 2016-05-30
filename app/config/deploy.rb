set :symfony_env,          "production"
set :stages,               %w{production}
set :default_stage,        "production"
set :stage_dir,            "app/config"

require 'capistrano/ext/multistage'

set :deploy_to,   "/var/www/html/holidays"
set :application, "holidays"

# symfony-standard edition directories
set :app_path, "app"
set :web_path, "web"
set :var_path, "var"
set :bin_path, "bin"

# The next 3 settings are lazily evaluated from the above values, so take care
# when modifying them
set :app_config_path, "app/config"
set :log_path, "var/logs"
set :cache_path, "var/cache"

set :symfony_console_path, "bin/console"
set :symfony_console_flags, "--no-debug"

set :repository, "git@github.com:gitleha/holiday.git"
set :scm, :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`
set :deploy_via, :copy

set :model_manager, "doctrine"
# Or: `propel`


# Remove app_dev.php during deployment, other files in web/ can be specified here
set :controllers_to_clear, ["app_*.php"]

# asset management
set :assets_install_path, "web"
set :assets_install_flags,  '--symlink'

# Share files/directories between releases
set :linked_files, []
set :linked_dirs, ["var/logs"]

# Set correct permissions between releases, this is turned off by default
set :file_permissions_paths, ["var"]
set :permission_method, false

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
