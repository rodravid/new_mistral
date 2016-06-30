node[:deploy].each do |app_name, deploy|
  current_path = "#{deploy[:deploy_to]}/current"
  script "composer_install_and_chmod" do
    interpreter "bash"
    user "root"
    cwd "#{current_path}"
    code <<-EOH
    ln -s #{current_path}/storage/app/public/ #{current_path}/public/storage
    php artisan queue:work --queue=emails --daemon --tries=3
    sudo npm install
    gulp --production 
    EOH
  end
end 