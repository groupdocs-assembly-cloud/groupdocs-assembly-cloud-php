parameters {
        string(name: 'branch', defaultValue: 'master', description: 'branch to test')		
		string(name: 'testServerUrl', defaultValue: 'https://api-qa.groupdocs.cloud', description: 'server url')		
}

node('words-linux') {
    dir('test'){
        try {
            stage('checkout'){
				checkout([$class: 'GitSCM', branches: [[name: params.branch]], doGenerateSubmoduleConfigurations: false, extensions: [[$class: 'LocalBranch', localBranch: "**"]], submoduleCfg: [], userRemoteConfigs: [[credentialsId: '361885ba-9425-4230-950e-0af201d90547', url: 'https://git.auckland.dynabic.com/assembly-cloud/assembly-php-sdk.git']]])
                withCredentials([usernamePassword(credentialsId: '6179b564-811f-48a9-8b85-875076fadbf5', passwordVariable: 'AppKey', usernameVariable: 'AppSid')]) {
					sh 'mkdir -p Settings'
                    sh 'echo "{\\"AppSid\\": \\"$AppSid\\",\\"AppKey\\": \\"$AppKey\\", \\"BaseUrl\\": \\"$testServerUrl\\"}" > Settings/servercreds.json'
                }
            }
            
            stage('tests'){   
                try {
                    sh "docker run --rm -v ${pwd()}:/app composer require --dev phpunit/phpunit ^4.8"
                    sh "docker run -v ${pwd()}:/app -v ${pwd()}/TestData:/app/TestData -w /app --rm phpunit/phpunit:4.8.3 -c phpunit.xml"
                } finally {
                    junit 'testReports/logfile.xml'
                }
            }      
        } finally {                       
            deleteDir()
        }
    }
}