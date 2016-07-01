node[:deploy].each do |app_name, deploy|
  current_path = "#{deploy[:deploy_to]}/current"
  script "composer_install_and_chmod" do
    interpreter "bash"
    user "root"
    cwd "#{current_path}"
    code <<-EOH
    ln -s #{current_path}/storage/app/public/ #{current_path}/public/storage
    sudo npm install
    gulp --production 
    EOH
  end
  
  include_recipe "supervisor"
  
  # http://supervisord.org/configuration.html#program-x-section-values
  supervisor_service "laravel_worker" do
    action :enable
    process_name "%(program_name)s_%(process_num)02d"
    command "php #{current_path} queue:work --queue=emails --daemon --tries=3"
    autostart true
    autorestart true
    numprocs 4
    redirect_stderr true
    stdout_logfile "/tmp/worker.log"
  end
  
end 