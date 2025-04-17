set :stage,  :production
set :branch, "master"
set :application, "holiday"
set :deploy_to,   "/var/www/html/holiday"

server 'oweb01:22', user: 'root'
server 'oweb02:22', user: 'root'
server 'oweb03:22', user: 'root'
server 'oweb04:22', user: 'root'

