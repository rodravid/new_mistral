node[:deploy].each do |app_name, deploy|
  current_path = "#{deploy[:deploy_to]}/current"
  if ::File.exist?("#{current_path}/composer.json") && !::Dir.exist?("#{current_path}/vendor")
    script "composer_install_and_chmod" do
      interpreter "bash"
      user "root"
      cwd "#{current_path}"
      code <<-EOH
      chmod -R 777 storage
      chmod -R 777 bootstrap/cache
      ln -s #{current_path}/storage/app/public/ #{current_path}/public/storage
      php artisan route:cache
      php artisan config:cache
      EOH
    end
  end
end 