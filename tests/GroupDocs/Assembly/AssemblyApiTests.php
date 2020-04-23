<?php
/*
* --------------------------------------------------------------------------------------------------------------------
* <copyright company="GroupDocs" file="GroupDocs\Assembly\AssemblyApiTest.php">
*   Copyright (c) 2020 GroupDocs.Assembly for Cloud
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
require_once $_SERVER['DOCUMENT_ROOT'] . "tests/GroupDocs/Assembly/BaseTestContext.php";
use GroupDocs\Assembly\Model;
use GroupDocs\Assembly\Model\Requests;
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
    public function testAssembleDocument()
    {
        $baseTestDir = realpath(__DIR__ . '/../../..') . '/TestData/';
        $fileName = 'TableFeatures.odt';
        $remoteName = $fileName;
        $fullName = self::$baseRemoteFolder . "GroupDocs/Assembly/" . $remoteName;
        $file = $baseTestDir . $fileName;
        $putRequest = new Requests\UploadFileRequest($file, $fullName);
        $this->assembly->uploadFile($putRequest);
        $reportData = file_get_contents(realpath($baseTestDir . 'TableData.json'));

        $assembleData = new Model\AssembleOptions(array("template_file_info"=>new Model\TemplateFileInfo(array("file_path"=> $fullName)), "save_format"=>"pdf", "report_data"=> $reportData));

        $request = new Requests\AssembleDocumentRequest($assembleData);

        $result = $this->assembly->assembleDocument($request);
        Assert::assertTrue($result->getSize() > 0, "Error while assemble");
    }
}