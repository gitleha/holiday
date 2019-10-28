# config valid only for current version of Capistrano
set :application, "holiday"
set :repo_url, "git@github.com:gitleha/holiday.git"

# To make safe to deploy to same server
set :tmp_dir, "/tmp/MDP"

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/holiday
set :deploy_to, '/var/www/html/holiday'

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :airbrussh.
# set :format, :airbrussh

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
# set :format_options, command_output: true, log_file: 'log/capistrano.log', color: :auto, truncate: :auto

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
set :linked_files, fetch(:linked_files, []).push('app/config/parameters.yml')

# Default value for linked_dirs is []
set :linked_dirs, fetch(:linked_dirs, []).push('var')

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# set :keep_releases, 3

after 'deploy:starting', 'composer:install_executable'
after 'deploy:updated', 'symfony:assets:install'
after 'deploy:updated', 'deploy:migrate'

namespace :deploy do

  after :restart, :clear_cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
    end
  end

end

# Run migrations after code is deployed (but not switched yet)
namespace :deploy do
  task :migrate do
    on roles(:db) do
      symfony_console('doctrine:migrations:migrate', '--no-interaction')
    end
  end
end