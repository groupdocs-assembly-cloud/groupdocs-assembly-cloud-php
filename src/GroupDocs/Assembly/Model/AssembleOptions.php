<?php
/**
 * --------------------------------------------------------------------------------------------------------------------
 * <copyright company="Aspose" file="AssembleOptions.php">
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
/*
 * AssembleOptions
 */

namespace GroupDocs\Assembly\Model;

use \ArrayAccess;
use \GroupDocs\Assembly\ObjectSerializer;

/*
 * AssembleOptions
 *
 * @description Assemble options data which is using for specifying assemble options, like template name, save format, report data and etc.
 */
class AssembleOptions implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /*
     * The original name of the model.
     *
     * @var string
     */
    protected static $swaggerModelName = "AssembleOptions";

    /*
     * Array of property to type mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerTypes = [
        'template_file_info' => '\GroupDocs\Assembly\Model\TemplateFileInfo',
        'save_format' => 'string',
        'report_data' => 'string',
        'output_path' => 'string'
    ];

    /*
     * Array of property to format mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerFormats = [
        'template_file_info' => null,
        'save_format' => null,
        'report_data' => null,
        'output_path' => null
    ];

    /*
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /*
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /*
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'template_file_info' => 'TemplateFileInfo',
        'save_format' => 'SaveFormat',
        'report_data' => 'ReportData',
        'output_path' => 'OutputPath'
    ];

    /*
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'template_file_info' => 'setTemplateFileInfo',
        'save_format' => 'setSaveFormat',
        'report_data' => 'setReportData',
        'output_path' => 'setOutputPath'
    ];

    /*
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'template_file_info' => 'getTemplateFileInfo',
        'save_format' => 'getSaveFormat',
        'report_data' => 'getReportData',
        'output_path' => 'getOutputPath'
    ];

    /*
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /*
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /*
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /*
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /*
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /*
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['template_file_info'] = isset($data['template_file_info']) ? $data['template_file_info'] : null;
        $this->container['save_format'] = isset($data['save_format']) ? $data['save_format'] : null;
        $this->container['report_data'] = isset($data['report_data']) ? $data['report_data'] : null;
        $this->container['output_path'] = isset($data['output_path']) ? $data['output_path'] : null;
    }

    /*
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /*
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        return true;
    }


    /*
     * Gets template_file_info
     *
     * @return \GroupDocs\Assembly\Model\TemplateFileInfo
     */
    public function getTemplateFileInfo()
    {
        return $this->container['template_file_info'];
    }

    /*
     * Sets template_file_info
     *
     * @param \GroupDocs\Assembly\Model\TemplateFileInfo $template_file_info Gets or sets the template name which is located on storage.
     *
     * @return $this
     */
    public function setTemplateFileInfo($template_file_info)
    {
        $this->container['template_file_info'] = $template_file_info;

        return $this;
    }

    /*
     * Gets save_format
     *
     * @return string
     */
    public function getSaveFormat()
    {
        return $this->container['save_format'];
    }

    /*
     * Sets save_format
     *
     * @param string $save_format Gets or sets a save format for assembled document.
     *
     * @return $this
     */
    public function setSaveFormat($save_format)
    {
        $this->container['save_format'] = $save_format;

        return $this;
    }

    /*
     * Gets report_data
     *
     * @return string
     */
    public function getReportData()
    {
        return $this->container['report_data'];
    }

    /*
     * Sets report_data
     *
     * @param string $report_data Gets or sets a data for report.
     *
     * @return $this
     */
    public function setReportData($report_data)
    {
        $this->container['report_data'] = $report_data;

        return $this;
    }

    /*
     * Gets output_path
     *
     * @return string
     */
    public function getOutputPath()
    {
        return $this->container['output_path'];
    }

    /*
     * Sets output_path
     *
     * @param string $output_path Gets or sets result path of a built document.
     *
     * @return $this
     */
    public function setOutputPath($output_path)
    {
        $this->container['output_path'] = $output_path;

        return $this;
    }
    /*
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /*
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /*
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /*
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /*
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


