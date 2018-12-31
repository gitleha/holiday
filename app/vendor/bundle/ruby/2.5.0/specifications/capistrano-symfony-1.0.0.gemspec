# -*- encoding: utf-8 -*-
# stub: capistrano-symfony 1.0.0 ruby lib

Gem::Specification.new do |s|
  s.name = "capistrano-symfony".freeze
  s.version = "1.0.0"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Peter Mitchell".freeze]
  s.date = "2018-09-06"
  s.description = "Symfony specific Capistrano tasks".freeze
  s.email = ["pete@peterjmit.com".freeze]
  s.homepage = "http://github.com/capistrano/capistrano-symfony".freeze
  s.licenses = ["MIT".freeze]
  s.post_install_message = "  WARNING - This gem has switched repositories. This gem is now for the\n  capistrano-symfony plugin located at https://github.com/capistrano/symfony.\n  This package behaves differently from the previous, and the release versions\n  have changed.\n\n  The Big Brains Company and Thomas Tourlourat (@armetiz) kindly agreed to\n  transfer the ownership of this gem over to the Capistrano organization. The\n  previous repository can be found here https://github.com/TheBigBrainsCompany/capistrano-symfony\n".freeze
  s.rubygems_version = "2.7.6".freeze
  s.summary = "Capistrano Symfony - Easy deployment of Symfony 2 & 3 apps with Ruby over SSH".freeze

  s.installed_by_version = "2.7.6" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_runtime_dependency(%q<capistrano>.freeze, ["~> 3.1"])
      s.add_runtime_dependency(%q<capistrano-composer>.freeze, ["~> 0.0.3"])
      s.add_runtime_dependency(%q<capistrano-file-permissions>.freeze, ["~> 1.0"])
    else
      s.add_dependency(%q<capistrano>.freeze, ["~> 3.1"])
      s.add_dependency(%q<capistrano-composer>.freeze, ["~> 0.0.3"])
      s.add_dependency(%q<capistrano-file-permissions>.freeze, ["~> 1.0"])
    end
  else
    s.add_dependency(%q<capistrano>.freeze, ["~> 3.1"])
    s.add_dependency(%q<capistrano-composer>.freeze, ["~> 0.0.3"])
    s.add_dependency(%q<capistrano-file-permissions>.freeze, ["~> 1.0"])
  end
end
