pipeline {
   agent {
        dockerfile {
            dir 'docker'
            additionalBuildArgs '--build-arg ssh_prv_key="$(cat ~/.ssh/id_rsa_holiday)" --build-arg ssh_pub_key="$(cat ~/.ssh/id_rsa_holiday.pub)"'
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
            sh 'touch test && tail -f test'
                sh 'eval "$(ssh-agent -s)" && ssh-add ~/.ssh/id_rsa && bundle install && bundle exec cap recette deploy'
            }
        }
   }
}