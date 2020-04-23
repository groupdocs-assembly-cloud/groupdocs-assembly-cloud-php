parameters {
        string(name: 'branch', defaultValue: 'master', description: 'branch to test')		
		string(name: 'testServerUrl', defaultValue: 'https://api-qa.groupdocs.cloud/', description: 'server url')		
}

def runtests(dockerImageVersion)
{
    dir(dockerImageVersion){
        try {
            stage('checkout'){
				checkout([$class: 'GitSCM', branches: [[name: params.branch]], doGenerateSubmoduleConfigurations: false, extensions: [[$class: 'LocalBranch', localBranch: "**"]], submoduleCfg: [], userRemoteConfigs: [[credentialsId: '361885ba-9425-4230-950e-0af201d90547', url: 'https://git.auckland.dynabic.com/assembly-cloud/assembly-php-sdk.git']]])
                withCredentials([usernamePassword(credentialsId: '82329510-1355-497f-828a-b8ff8b5f6a30', passwordVariable: 'AppKey', usernameVariable: 'AppSid')]) {
					sh 'mkdir -p Settings'
                    sh 'echo "{\\"AppSid\\": \\"$AppSid\\",\\"AppKey\\": \\"$AppKey\\", \\"BaseUrl\\": \\"$testServerUrl\\"}" > Settings/servercreds.json'
                }
            }
            
            def testImage = docker.build("groupdocsassembly:${dockerImageVersion}", "./docker/${dockerImageVersion}")
            
            testImage.inside {
                stage('tests'){   
					try {
                        sh "php composer.phar install --no-interaction"
                        sh "php composer.phar dump-autoload -o"
						sh "php vendor/bin/phpunit -c phpunit.xml"
					} finally {
						junit 'testReports/logfile.xml'
					}
                }
            }        
        } finally {                       
            deleteDir()
        }
    }
}

node('words-linux') {
    runtests("latest")
	runtests("7.1")
}