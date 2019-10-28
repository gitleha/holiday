pipeline {
   agent {
        dockerfile {
            dir 'docker'
            additionalBuildArgs '--build-arg ssh_prv_key="$(cat ~/.ssh/id_rsa)" --build-arg ssh_pub_key="$(cat ~/.ssh/id_rsa.pub)"'
            args '-u 0'
        }
    }
    stages {
        stage('build') {
            steps {
                checkout scm
                sh "ln -s ${env.workspace}/web /web"
                sh 'mkdir -p var'
                sh 'composer install'
                sh 'yarn install'
                sh 'chown -R apache:apache var'
            }
        }
        stage ('deploy-doc') {
            steps {
                sh 'cd docs && sphinx-build-3 -b html . build'
            }
        }
        stage ('deploy') {
            steps {
                sh 'eval "$(ssh-agent -s)" && ssh-add ~/.ssh/id_rsa && bundle install && bundle exec cap recette deploy'
            }
        }
   }
}