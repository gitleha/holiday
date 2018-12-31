# -*- encoding: utf-8 -*-
# stub: capistrano-file-permissions 1.0.0 ruby lib

Gem::Specification.new do |s|
  s.name = "capistrano-file-permissions".freeze
  s.version = "1.0.0"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Peter Mitchell".freeze]
  s.date = "2016-01-15"
  s.description = "File permissions management for Capistrano 3.x".freeze
  s.email = ["peterjmit@gmail.com".freeze]
  s.homepage = "https://github.com/capistrano/file-permissions".freeze
  s.licenses = ["MIT".freeze]
  s.rubygems_version = "2.7.6".freeze
  s.summary = "File permissions management for Capistrano 3.x".freeze

  s.installed_by_version = "2.7.6" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_runtime_dependency(%q<capistrano>.freeze, ["~> 3.0"])
    else
      s.add_dependency(%q<capistrano>.freeze, ["~> 3.0"])
    end
  else
    s.add_dependency(%q<capistrano>.freeze, ["~> 3.0"])
  end
end
