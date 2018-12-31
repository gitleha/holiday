# -*- encoding: utf-8 -*-
# stub: capistrano-composer 0.0.6 ruby lib

Gem::Specification.new do |s|
  s.name = "capistrano-composer".freeze
  s.version = "0.0.6"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Scott Walkinshaw".freeze, "Peter Mitchell".freeze]
  s.date = "2015-02-18"
  s.description = "Composer support for Capistrano 3.x".freeze
  s.email = ["scott.walkinshaw@gmail.com".freeze, "peterjmit@gmail.com".freeze]
  s.homepage = "https://github.com/capistrano/composer".freeze
  s.licenses = ["MIT".freeze]
  s.rubygems_version = "2.7.6".freeze
  s.summary = "Composer support for Capistrano 3.x".freeze

  s.installed_by_version = "2.7.6" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_runtime_dependency(%q<capistrano>.freeze, [">= 3.0.0.pre"])
      s.add_development_dependency(%q<bundler>.freeze, ["~> 1.3"])
      s.add_development_dependency(%q<rake>.freeze, ["~> 10.1"])
    else
      s.add_dependency(%q<capistrano>.freeze, [">= 3.0.0.pre"])
      s.add_dependency(%q<bundler>.freeze, ["~> 1.3"])
      s.add_dependency(%q<rake>.freeze, ["~> 10.1"])
    end
  else
    s.add_dependency(%q<capistrano>.freeze, [">= 3.0.0.pre"])
    s.add_dependency(%q<bundler>.freeze, ["~> 1.3"])
    s.add_dependency(%q<rake>.freeze, ["~> 10.1"])
  end
end
