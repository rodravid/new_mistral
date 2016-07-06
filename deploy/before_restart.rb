node[:deploy].each do |app_name, deploy|
  current_path = "#{deploy[:deploy_to]}/current"
  script "composer_install_and_chmod" do
    interpreter "bash"
    user "root"
    cwd "#{current_path}"
    code <<-EOH
    ln -s #{current_path}/storage/app/public/ #{current_path}/public/storage
    nohup php artisan queue:work --queue=vinci-queue --tries=3 --daemon > /dev/null 2>1 &
    npm install
    gulp --production 
    EOH
  end
end 