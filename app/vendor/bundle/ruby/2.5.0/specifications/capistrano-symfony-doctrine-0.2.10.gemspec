# -*- encoding: utf-8 -*-
# stub: capistrano-symfony-doctrine 0.2.10 ruby lib

Gem::Specification.new do |s|
  s.name = "capistrano-symfony-doctrine".freeze
  s.version = "0.2.10"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.metadata = { "allowed_push_host" => "https://rubygems.org" } if s.respond_to? :metadata=
  s.require_paths = ["lib".freeze]
  s.authors = ["Emil Kilhage".freeze]
  s.bindir = "exe".freeze
  s.date = "2016-11-22"
  s.description = "doctrine migrations & cache clearing support for Capistrano 3.x".freeze
  s.email = ["emil.kilhage@glooby.com".freeze]
  s.homepage = "https://www.glooby.se".freeze
  s.licenses = ["MIT".freeze]
  s.rubygems_version = "2.7.6".freeze
  s.summary = "doctrine migrations & cache clearing support for Capistrano 3.x".freeze

  s.installed_by_version = "2.7.6" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_runtime_dependency(%q<capistrano>.freeze, [">= 3.1.0"])
      s.add_runtime_dependency(%q<capistrano-symfony>.freeze, [">= 0.4.0"])
      s.add_development_dependency(%q<bundler>.freeze, ["~> 1.10"])
      s.add_development_dependency(%q<rake>.freeze, ["~> 10.0"])
    else
      s.add_dependency(%q<capistrano>.freeze, [">= 3.1.0"])
      s.add_dependency(%q<capistrano-symfony>.freeze, [">= 0.4.0"])
      s.add_dependency(%q<bundler>.freeze, ["~> 1.10"])
      s.add_dependency(%q<rake>.freeze, ["~> 10.0"])
    end
  else
    s.add_dependency(%q<capistrano>.freeze, [">= 3.1.0"])
    s.add_dependency(%q<capistrano-symfony>.freeze, [">= 0.4.0"])
    s.add_dependency(%q<bundler>.freeze, ["~> 1.10"])
    s.add_dependency(%q<rake>.freeze, ["~> 10.0"])
  end
end
