<?php
/**
 * --------------------------------------------------------------------------------------------------------------------
 * <copyright company="GroupDocs" file="PostAssembleDocumentRequest.php">
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

namespace GroupDocs\Assembly\Model\Requests;

/*
 * Request model for postAssembleDocument operation.
 */
class PostAssembleDocumentRequest
{
    /*
     * File name of template, which is located on a storage
     */
    public $name;
	
    /*
     * Report Data Options. It should be JSON with SaveFormat and ReportData
     */
    public $report_data;
	
    /*
     * Folder path where template file is located(on a storage)
     */
    public $folder;
	
    /*
     * Result name of built document
     */
    public $dest_file_name;
    
	
    /*
     * Initializes a new instance of the PostAssembleDocumentRequest class.
     *  
     * @param string $name File name of template, which is located on a storage
     * @param \GroupDocs\Assembly\Model\ReportOptionsData $report_data Report Data Options. It should be JSON with SaveFormat and ReportData
     * @param string $folder Folder path where template file is located(on a storage)
     * @param string $dest_file_name Result name of built document
     */
    public function __construct($name, $report_data, $folder = null, $dest_file_name = null)             
    {
        $this->name = $name;
        $this->report_data = $report_data;
        $this->folder = $folder;
        $this->dest_file_name = $dest_file_name;
    }

    /*
     * File name of template, which is located on a storage
     */
    public function get_name()
    {
        return $this->name;
    }

    /*
     * File name of template, which is located on a storage
     */
    public function set_name($value)
    {
        $this->name = $value;
        return $this;
    }
	
    /*
     * Report Data Options. It should be JSON with SaveFormat and ReportData
     */
    public function get_report_data()
    {
        return $this->report_data;
    }

    /*
     * Report Data Options. It should be JSON with SaveFormat and ReportData
     */
    public function set_report_data($value)
    {
        $this->report_data = $value;
        return $this;
    }
	
    /*
     * Folder path where template file is located(on a storage)
     */
    public function get_folder()
    {
        return $this->folder;
    }

    /*
     * Folder path where template file is located(on a storage)
     */
    public function set_folder($value)
    {
        $this->folder = $value;
        return $this;
    }
	
    /*
     * Result name of built document
     */
    public function get_dest_file_name()
    {
        return $this->dest_file_name;
    }

    /*
     * Result name of built document
     */
    public function set_dest_file_name($value)
    {
        $this->dest_file_name = $value;
        return $this;
    }
}
