set :stage,  :production
set :branch, "master"
set :application, "holidays"
set :deploy_to,   "/var/www/html/holidays"

server 'oweb01:22', user: 'root'
server 'oweb02:22', user: 'root'
server 'oweb03:22', user: 'root'
server 'oweb04:22', user: 'root'

