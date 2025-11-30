pipeline {
    agent any

    stages {

        stage('Clonar repositorio') {
            steps {
                git url: 'https://github.com/paola-11/LaFeriaDelJuguete.git', branch: 'main'
            }
        }

        stage('Construir imagen Docker') {
            steps {
                sh 'docker-compose build'
            }
        }

        stage('Limpiar contenedores viejos') {
            steps {
                sh '''
                    docker rm -f granferia_db || true
                    docker rm -f granferia_web || true
                '''
            }
        }

        stage('Levantar contenedores') {
            steps {
                sh 'docker-compose up -d --force-recreate'
            }
        }

        stage('Probar contenedores') {
            steps {
               // Aquí se pueden agregar pruebas o validaciones 
                sh 'docker ps'
            }
        }
    }

    post {
        always {
            echo 'Pipeline finalizado.'
        }
    }
}
