# author: christian@bloglovin.comn
# Add your own tasks in files placed in lib/tasks ending in .rake,
# for example lib/tasks/capistrano.rake, and they will automatically be available to Rake.

ENV['base_dir'] = File.dirname(__FILE__)

# include commmon libs
require "#{ENV['base_dir']}/tasks/rake"

# include rake tasks
Dir.glob("#{ENV['base_dir']}/tasks/*.rake").each { | namespace | import namespace }
