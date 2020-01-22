<?php
/*
* --------------------------------------------------------------------------------------------------------------------
* <copyright company="GroupDocs" file="GroupDocs\Assembly\AssemblyApiTest.php">
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

function autoload( $path ) {
    $items = glob( $path . DIRECTORY_SEPARATOR . "*" );

    foreach( $items as $item ) {
        $pinfo = pathinfo( $item );         
        $isPhp = array_key_exists("extension", $pinfo) && $pinfo["extension"] === "php";
        if ( is_file( $item ) && $isPhp ) {
            require_once $item;
        } elseif ( is_dir( $item ) ) {
            autoload( $item );
        }
    }
}

autoload( $_SERVER['DOCUMENT_ROOT'] . "Assembly" );

require_once $_SERVER['DOCUMENT_ROOT'] . "tests/GroupDocs/Assembly/BaseTestContext.php";
use GroupDocs\Assembly\ApiException;
use GroupDocs\Assembly\Model;
use GroupDocs\Assembly\Model\Requests;
use Aspose\Storage\Model\Requests as StorageRequests;
use BaseTest\BaseTestContext;
use PHPUnit\Framework\Assert;
/**
 * Class for testing Assembly Api
 */
class AssemblyApiTests extends BaseTestContext
{
    /**
     * Test case for post assemble request
     * 
     * @return void
     */
    public function testPostAssembleDocument()
    {
        $baseTestDir = realpath(__DIR__ . '../../') . 'TestData/';
        $fileName = 'TestAllChartTypes.docx';
        $remoteName = $fileName;
        $fullName = self::$baseRemoteFolder . "GroupDocs.Assembly/" . $remoteName;
        $file = $baseTestDir . $fileName;
        $putRequest = new StorageRequests\PutCreateRequest($fullName, $file);
        $this->storage->PutCreate($putRequest);

        $request = new Requests\PostAssembleDocumentRequest(
            $remoteName, 
            $baseTestDir . "Teams.json", 
            new Model\LoadSaveOptionsData(array("save_format" => "pdf")), 
            self::$baseRemoteFolder . "GroupDocs.Assembly", 
            null
        );

        $result = $this->assembly->postAssembleDocument($request);
        Assert::assertNotNull($result, "Answer cannot be empty");
    }
}