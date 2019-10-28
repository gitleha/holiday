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
            }
        }
        stage ('deploy') {
            steps {
                sh 'cd app && eval "$(ssh-agent -s)" && ssh-add ~/.ssh/id_rsa && bundle install && bundle exec cap recette deploy'
            }
        }
   }
}