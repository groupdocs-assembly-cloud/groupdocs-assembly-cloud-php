# GroupDocs.Assembly Cloud SDK for PHP
This repository contains GroupDocs.Assembly Cloud SDK for PHP source code. This SDK allows you to work with GroupDocs.Assembly Cloud REST APIs in your PHP applications quickly and easily, with zero initial cost.

See [API Reference](https://apireference.groupdocs.cloud/) for full API specification.

## How to use the SDK?
The complete source code is available in this repository folder.  You can either directly use it in your project via source code or get [Packagist distribution](https://packagist.org/packages/groupdocs/assembly-sdk-php) (recommended). For more details, please visit our [documentation website](https://docs.groupdocs.cloud/display/assemblycloud/Available+SDKs).

### Prerequisites

To use GroupDocs.Assembly for Cloud PHP SDK you need to register an account with [GroupDocs Cloud](https://www.groupdocs.cloud/) and lookup/create App Key and SID at [Cloud Dashboard](https://dashboard.groupdocs.cloud/#/apps). There is free quota available. For more details, see [GroupDocs Cloud Pricing](https://purchase.groupdocs.cloud/pricing).

### Installation

#### Via Composer:
*assembly-sdk-php* is available on Packagist as the
[`assembly-sdk-php`](https://packagist.org/packages/groupdocs/assembly-sdk-php) package. Run the following command:
```bash
composer require groupdocs/assembly-sdk-php
```

To use the SDK, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```
### Sample usage

```php
$config = new Configuration();
$config->setAppKey('AppKey')->setAppSid('AppSid');
$assembly = new AssemblyApi(null, $config);
$request = new Requests\PostAssembleDocumentRequest(
            $remoteName, 
            $dataFileName, 
            new Model\LoadSaveOptionsData(array("save_format" => "docx")), 
            null, 
            null
        );
$result = $assembly->postAssembleDocument($request);
```
      
[Tests](tests/) contain various examples of using the SDK.
Please put your credentials into [Configuration](Settings/servercreds.json).

## Dependencies
- PHP 5.6 or later
- referenced packages (see [here](composer.json) for more details)

## Contact Us
Your feedback is very important to us. Please feel free to contact us using our [Support Forums](https://forum.groupdocs.cloud/c/assembly).