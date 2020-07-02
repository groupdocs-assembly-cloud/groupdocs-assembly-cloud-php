# GroupDocs.Assembly Cloud SDK for PHP
This repository contains GroupDocs.Assembly Cloud SDK for PHP source code. This SDK allows you to work with GroupDocs.Assembly Cloud REST APIs in your PHP applications quickly and easily, with zero initial cost.

See [API Reference](https://apireference.groupdocs.cloud/) for full API specification.

## How to use the SDK?
The complete source code is available in this repository folder.  You can either directly use it in your project via source code or get [Packagist distribution](https://packagist.org/packages/groupdocscloud/groupdocs-assembly-cloud) (recommended). For more details, please visit our [documentation website](https://docs.groupdocs.cloud/display/assemblycloud/Available+SDKs).

### Prerequisites

To use GroupDocs.Assembly for Cloud PHP SDK you need to register an account with [GroupDocs Cloud](https://www.groupdocs.cloud/) and lookup/create App Key and SID at [Cloud Dashboard](https://dashboard.groupdocs.cloud/#/apps). There is free quota available. For more details, see [GroupDocs Cloud Pricing](https://purchase.groupdocs.cloud/pricing).

### Installation

#### Via Composer:
*groupdocs-assembly-cloud* is available on Packagist as the
[`groupdocs-assembly-cloud`](https://packagist.org/packages/groupdocscloud/groupdocs-assembly-cloud) package. Run the following command:
```bash
composer require groupdocscloud/groupdocs-assembly-cloud
```

To use the SDK, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```
### Sample usage

```php
$assembly = new AssemblyApi($creds["AppSid"], $creds["AppKey"], $creds["BaseUrl"]);
$reportData = file_get_contents('FileWithData');
$assembleData = new Model\AssembleOptions(array("template_file_info"=>new Model\TemplateFileInfo(array("file_path"=> 'FileNameInStorage')), "save_format"=>"pdf", "report_data"=> $reportData));
$request = new Requests\AssembleDocumentRequest($assembleData);
$result = $assembly->assembleDocument($request);
```
      
[Tests](tests/) contain various examples of using the SDK.
Please put your credentials into [Configuration](Settings/servercreds.json).

## Dependencies
- PHP 5.6 or later
- referenced packages (see [here](composer.json) for more details)

## Contact Us
Your feedback is very important to us. Please feel free to contact us using our [Support Forums](https://forum.groupdocs.cloud/c/assembly).