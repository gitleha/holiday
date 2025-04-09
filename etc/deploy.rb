# config valid for current version and patch releases of Capistrano
lock "3.10.2"

set :application, "holiday"
set :repo_url, "git@github.com:gitleha/holiday.git"
set :deploy_to, "/var/www/html/holiday"
set :file_permissions_paths, ["var/logs", "var/cache", "var/sessions"]
set :file_permissions_users, ["www-data"]

before "deploy:updated", "deploy:set_permissions:acl"
set :pty, true
append :linked_files, "app/config/parameters.yml"
append :linked_dirs, ["var/logs"]