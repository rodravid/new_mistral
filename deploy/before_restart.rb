node[:deploy].each do |app_name, deploy|
  current_path = "#{deploy[:deploy_to]}/current"
  if ::File.exist?("#{current_path}/composer.json") && !::Dir.exist?("#{current_path}/vendor")
    script "composer_install_and_chmod" do
      interpreter "bash"
      user "root"
      cwd "#{current_path}"
      code <<-EOH
      rm -R storage/framework/cache
      ln -s #{current_path}/storage/app/public/ #{current_path}/public/storage
      chmod -R 777 bootstrap/cache
      /usr/bin/php artisan cache:clear
      /usr/bin/php artisan route:cache
      /usr/bin/php artisan config:cache
      chmod -R 777 storage
      EOH
    end
  end
end 