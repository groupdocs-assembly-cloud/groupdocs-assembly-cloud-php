parameters {
        string(name: 'branch', defaultValue: 'master', description: 'branch to test')		
		string(name: 'testServerUrl', defaultValue: 'https://api-qa.groupdocs.cloud', description: 'server url')		
}

node('words-linux') {
    dir('test'){
        try {
            stage('checkout'){
				checkout([$class: 'GitSCM', branches: [[name: params.branch]], doGenerateSubmoduleConfigurations: false, extensions: [[$class: 'LocalBranch', localBranch: "**"]], submoduleCfg: [], userRemoteConfigs: [[credentialsId: '361885ba-9425-4230-950e-0af201d90547', url: 'https://git.auckland.dynabic.com/assembly-cloud/assembly-php-sdk.git']]])
                withCredentials([usernamePassword(credentialsId: '82329510-1355-497f-828a-b8ff8b5f6a30', passwordVariable: 'AppKey', usernameVariable: 'AppSid')]) {
					sh 'mkdir -p Settings'
                    sh 'echo "{\\"AppSid\\": \\"$AppSid\\",\\"AppKey\\": \\"$AppKey\\", \\"BaseUrl\\": \\"$testServerUrl\\"}" > Settings/servercreds.json'
                }
            }
            
            stage('tests'){   
                try {
                    sh "docker run -v %cd%/:/opt/project -w="/opt/project" composer composer install --no-interaction"
                    sh "docker run -v %cd%:/PHP -v %cd%/Settings/servercreds.json:/servercreds.json -v %cd%/TestData:/TestData -w="/PHP" --rm php:7.2.2 vendor/bin/phpunit -c phpunit.xml"
                } finally {
                    junit 'testReports/logfile.xml'
                }
            }      
        } finally {                       
            deleteDir()
        }
    }
}