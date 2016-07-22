node[:deploy].each do |app_name, deploy|
  current_path = "#{deploy[:deploy_to]}/current"
  script "composer_install_and_chmod" do
    interpreter "bash"
    user "root"
    cwd "#{current_path}"
    code <<-EOH
    EOH
  end
end 
