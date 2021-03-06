<?php
/*
* --------------------------------------------------------------------------------------------------------------------
* <copyright company="GroupDocs" file="BaseTestContext.php">
*   Copyright (c) 2019 GroupDocs.Assembly for Cloud
* </copyright>
* <summary>
*   Permission is hereby granted, free of charge, to any person obtaining a copy
*  of this software and associated documentation files (the "Software"), to deal
*  in the Software without restriction, including without limitation the rights
*  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
*  copies of the Software, and to permit persons to whom the Software is
*  furnished to do so, subject to the following conditions:
*
*  The above copyright notice and this permission notice shall be included in all
*  copies or substantial portions of the Software.
*
*  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
*  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
*  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
*  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
*  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
*  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
*  SOFTWARE.
* </summary>
* --------------------------------------------------------------------------------------------------------------------
*/
namespace GroupDocs\Assembly\Test;
use GroupDocs\Assembly\AssemblyApi;
use GroupDocs\Assembly\Model\Requests;

/**
 * Base context for test classes
 */
class BaseTestContext extends \PHPUnit_Framework_TestCase
{
    protected $assembly;

    protected $storage;

    protected $config;
    protected static $baseTestPath = "Temp/SdkTests/TestData/";
    public static $baseTestOut = "TestOut/";
    public static $baseRemoteFolder = "Temp/SdkTests/php/";

    /**
     * Setup before running each test case
     * 
     * @return void
     */
    public function setUp()
    {
        $creds = \GuzzleHttp\json_decode(file_get_contents(realpath(__DIR__  . '/../../..' . "/Settings/servercreds.json")), true);
        /*
         * To run with your own credentials please, replace parameter in methods 'setAppKey' and 'setAppSid' accordingly to your's AppSid and AppKey
         */
        $this->assembly = new AssemblyApi($creds["AppSid"], $creds["AppKey"]);
        $this->assembly->getConfig()->setHost($creds["BaseUrl"]);
    }

    public function uploadFile($file, $path){
        $request = new Requests\UploadFileRequest($file, $path);
        $result = $this->assembly->uploadFile($request);
    }

    /*
     * Returns api instance
     * 
     * @return AssemblyApi
     */
    public function get_api()
    {
        return $this->assembly;
    }
}