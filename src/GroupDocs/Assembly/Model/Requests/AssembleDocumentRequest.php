<?php
}
/**
 * --------------------------------------------------------------------------------------------------------------------
 * <copyright company="Aspose" file="AssembleDocumentRequest.php">
 *   Copyright (c) 2021 GroupDocs.Assembly for Cloud
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

namespace GroupDocs\Assembly\Model\Requests;

/*
 * Request model for assembleDocument operation.
 */
class AssembleDocumentRequest
{
    /*
     * Assemble Options. It should be JSON or XML with TemplateFileInfo, SaveFormat, ReportData and etc.
     */
    public $assemble_options;
    
	
    /*
     * Initializes a new instance of the AssembleDocumentRequest class.
     *  
     * @param \GroupDocs\Assembly\Model\AssembleOptions $assemble_options Assemble Options. It should be JSON or XML with TemplateFileInfo, SaveFormat, ReportData and etc.
     */
    public function __construct($assemble_options)             
    {
        $this->assemble_options = $assemble_options;
    }

    /*
     * Assemble Options. It should be JSON or XML with TemplateFileInfo, SaveFormat, ReportData and etc.
     */
    public function get_assemble_options()
    {
        return $this->assemble_options;
    }

    /*
     * Assemble Options. It should be JSON or XML with TemplateFileInfo, SaveFormat, ReportData and etc.
     */
    public function set_assemble_options($value)
    {
        $this->assemble_options = $value;
        return $this;
    }
