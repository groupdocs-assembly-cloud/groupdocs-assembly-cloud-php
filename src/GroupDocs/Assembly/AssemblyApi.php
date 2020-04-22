<?php
/**
 * --------------------------------------------------------------------------------------------------------------------
 * <copyright company="Aspose" file="AssemblyApi.php">
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

namespace GroupDocs\Assembly;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use GroupDocs\Assembly\Model\Requests;

/*
 * AssemblyApi GroupDocs.Assembly for Cloud API.
 */
class AssemblyApi
{
    /*
     * Stores client instance
     * @var ClientInterface client for calling api
     */
    protected $client;

    /*
     * Stores configuration
     * @var Configuration configuration info
     */
    protected $config;

    /*
     * Stores header selector
     * HeaderSelector class for header selection
     */
    protected $headerSelector;

    /*
     * Initialize a new instance of WordsApi
     * @param string   $appSid client app sid
     * @param string   $appKey app key
     * @param string   $baseUrl base url for requests
     */
    public function __construct(string $appSid, string $appKey, string $baseUrl)
    {
        $this->client = new Client();
        $this->config = new Configuration($appSid, $appKey, $baseUrl);
        $this->headerSelector = new HeaderSelector();
        $this->_requestToken();
    }

    /*
     * Gets the config
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /*
     * Operation assembleDocument
     *
     * Builds a document using document template and XML or JSON data passed in request.
     *
     * @param Requests\assembleDocumentRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \SplFileObject
     */
    public function assembleDocument(Requests\assembleDocumentRequest $request)
    {
        try {
            list($response) = $this->assembleDocumentWithHttpInfo($request);
            return $response;
        } catch (RepeatRequestException $e) {
            list($response) = $this->assembleDocumentWithHttpInfo($request);
            return $response;
        }
    }

    /*
     * Operation assembleDocumentWithHttpInfo
     *
     * Builds a document using document template and XML or JSON data passed in request.
     *
     * @param Requests\assembleDocumentRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \SplFileObject, HTTP status code, HTTP response headers (array of strings)
     */
    public function assembleDocumentWithHttpInfo(Requests\assembleDocumentRequest $request)
    {
        $returnType = '\SplFileObject';
        $request = $this->assembleDocumentRequest($request);

        try {
            $options = $this->_createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                if ($statusCode === 401) {
                    $this->_requestToken();
                    throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                }

                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            if ($this->config->getDebug()) {
                $this->_writeResponseLog($statusCode, $response->getHeaders(), ObjectSerializer::deserialize($content, $returnType, []));
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize($e->getResponseBody(), '\SplFileObject', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /*
     * Operation assembleDocumentAsync
     *
     * Builds a document using document template and XML or JSON data passed in request.
     *
     * @param Requests\assembleDocumentRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function assembleDocumentAsync(Requests\assembleDocumentRequest $request)
    {
        return $this->assembleDocumentAsyncWithHttpInfo($request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /*
     * Operation assembleDocumentAsyncWithHttpInfo
     *
     * Builds a document using document template and XML or JSON data passed in request.
     *
     * @param Requests\assembleDocumentRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function assembleDocumentAsyncWithHttpInfo(Requests\assembleDocumentRequest $request)
    {
        $returnType = '\SplFileObject';
        $request = $this->assembleDocumentRequest($request);

        return $this->client
            ->sendAsync($request, $this->_createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    if ($this->config->getDebug()) {
                        $this->_writeResponseLog($response->getStatusCode(), $response->getHeaders(), ObjectSerializer::deserialize($content, $returnType, []));
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($exception instanceof RepeatRequestException) {
                        $this->_refreshToken();
                        throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                    }

                    throw new ApiException(
                        sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody()
                    );
                }
            );
    }

    /*
     * Create request for operation 'assembleDocument'
     *
     * @param Requests\assembleDocumentRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function assembleDocumentRequest(Requests\assembleDocumentRequest $request)
    {
        // verify the required parameter 'assemble_options' is set
        if ($request->assemble_options === null) {
            throw new \InvalidArgumentException('Missing the required parameter $assemble_options when calling assembleDocument');
        }

        $resourcePath = '/assembly/assemble';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = "";
        $multipart = false;


        $resourcePath = $this->_parseURL($resourcePath, $queryParams);

        // body params
        $_tempBody = null;
        if (isset($request->assemble_options)) {
            if (is_string($request->assemble_options)) {
                $_tempBody = "\"" . $request->assemble_options . "\"";
            } else {
                $_tempBody = $request->assemble_options;
            }
        }

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json', 'application/xml']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json', 'application/xml'],
                ['application/json', 'application/xml']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                        'filename' => basename($filename)
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = $formParams["data"];
            }
        }

        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['x-aspose-client'] = $this->config->getUserAgent();
        }

        $defaultHeaders['x-aspose-client-version'] = $this->config->getClientVersion();

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $req = new Request(
            'POST',
            $resourcePath,
            $headers,
            $httpBody
        );
        if ($this->config->getDebug()) {
            $this->_writeRequestLog('POST', $resourcePath, $headers, $httpBody);
        }

        return $req;
    }

    /*
     * Operation copyFile
     *
     * Copy file
     *
     * @param Requests\copyFileRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function copyFile(Requests\copyFileRequest $request)
    {
        try {
            $this->copyFileWithHttpInfo($request);
        } catch (RepeatRequestException $e) {
            $this->copyFileWithHttpInfo($request);
        }
    }

    /*
     * Operation copyFileWithHttpInfo
     *
     * Copy file
     *
     * @param Requests\copyFileRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function copyFileWithHttpInfo(Requests\copyFileRequest $request)
    {
        $returnType = '';
        $request = $this->copyFileRequest($request);

        try {
            $options = $this->_createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                if ($statusCode === 401) {
                    $this->_requestToken();
                    throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                }

                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /*
     * Operation copyFileAsync
     *
     * Copy file
     *
     * @param Requests\copyFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function copyFileAsync(Requests\copyFileRequest $request)
    {
        return $this->copyFileAsyncWithHttpInfo($request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /*
     * Operation copyFileAsyncWithHttpInfo
     *
     * Copy file
     *
     * @param Requests\copyFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function copyFileAsyncWithHttpInfo(Requests\copyFileRequest $request)
    {
        $returnType = '';
        $request = $this->copyFileRequest($request);

        return $this->client
            ->sendAsync($request, $this->_createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($exception instanceof RepeatRequestException) {
                        $this->_refreshToken();
                        throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                    }

                    throw new ApiException(
                        sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody()
                    );
                }
            );
    }

    /*
     * Create request for operation 'copyFile'
     *
     * @param Requests\copyFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function copyFileRequest(Requests\copyFileRequest $request)
    {
        // verify the required parameter 'dest_path' is set
        if ($request->dest_path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $dest_path when calling copyFile');
        }
        // verify the required parameter 'src_path' is set
        if ($request->src_path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $src_path when calling copyFile');
        }

        $resourcePath = '/assembly/storage/file/copy/{srcPath}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = "";
        $multipart = false;

        // path params
        if ($request->src_path !== null) {
            $localName = lcfirst('SrcPath');
            $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($request->src_path), $resourcePath);
        }

        // query params
        if ($request->dest_path !== null) {
            $localName = lcfirst('DestPath');
            $localValue = is_bool($request->dest_path) ? ($request->dest_path ? 'true' : 'false') : $request->dest_path;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->src_storage_name !== null) {
            $localName = lcfirst('SrcStorageName');
            $localValue = is_bool($request->src_storage_name) ? ($request->src_storage_name ? 'true' : 'false') : $request->src_storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->dest_storage_name !== null) {
            $localName = lcfirst('DestStorageName');
            $localValue = is_bool($request->dest_storage_name) ? ($request->dest_storage_name ? 'true' : 'false') : $request->dest_storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->version_id !== null) {
            $localName = lcfirst('VersionId');
            $localValue = is_bool($request->version_id) ? ($request->version_id ? 'true' : 'false') : $request->version_id;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }


        $resourcePath = $this->_parseURL($resourcePath, $queryParams);

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json', 'application/xml']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json', 'application/xml'],
                ['application/json', 'application/xml']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                        'filename' => basename($filename)
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = $formParams["data"];
            }
        }

        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['x-aspose-client'] = $this->config->getUserAgent();
        }

        $defaultHeaders['x-aspose-client-version'] = $this->config->getClientVersion();

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $req = new Request(
            'PUT',
            $resourcePath,
            $headers,
            $httpBody
        );
        if ($this->config->getDebug()) {
            $this->_writeRequestLog('PUT', $resourcePath, $headers, $httpBody);
        }

        return $req;
    }

    /*
     * Operation copyFolder
     *
     * Copy folder
     *
     * @param Requests\copyFolderRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function copyFolder(Requests\copyFolderRequest $request)
    {
        try {
            $this->copyFolderWithHttpInfo($request);
        } catch (RepeatRequestException $e) {
            $this->copyFolderWithHttpInfo($request);
        }
    }

    /*
     * Operation copyFolderWithHttpInfo
     *
     * Copy folder
     *
     * @param Requests\copyFolderRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function copyFolderWithHttpInfo(Requests\copyFolderRequest $request)
    {
        $returnType = '';
        $request = $this->copyFolderRequest($request);

        try {
            $options = $this->_createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                if ($statusCode === 401) {
                    $this->_requestToken();
                    throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                }

                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /*
     * Operation copyFolderAsync
     *
     * Copy folder
     *
     * @param Requests\copyFolderRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function copyFolderAsync(Requests\copyFolderRequest $request)
    {
        return $this->copyFolderAsyncWithHttpInfo($request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /*
     * Operation copyFolderAsyncWithHttpInfo
     *
     * Copy folder
     *
     * @param Requests\copyFolderRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function copyFolderAsyncWithHttpInfo(Requests\copyFolderRequest $request)
    {
        $returnType = '';
        $request = $this->copyFolderRequest($request);

        return $this->client
            ->sendAsync($request, $this->_createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($exception instanceof RepeatRequestException) {
                        $this->_refreshToken();
                        throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                    }

                    throw new ApiException(
                        sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody()
                    );
                }
            );
    }

    /*
     * Create request for operation 'copyFolder'
     *
     * @param Requests\copyFolderRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function copyFolderRequest(Requests\copyFolderRequest $request)
    {
        // verify the required parameter 'dest_path' is set
        if ($request->dest_path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $dest_path when calling copyFolder');
        }
        // verify the required parameter 'src_path' is set
        if ($request->src_path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $src_path when calling copyFolder');
        }

        $resourcePath = '/assembly/storage/folder/copy/{srcPath}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = "";
        $multipart = false;

        // path params
        if ($request->src_path !== null) {
            $localName = lcfirst('SrcPath');
            $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($request->src_path), $resourcePath);
        }

        // query params
        if ($request->dest_path !== null) {
            $localName = lcfirst('DestPath');
            $localValue = is_bool($request->dest_path) ? ($request->dest_path ? 'true' : 'false') : $request->dest_path;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->src_storage_name !== null) {
            $localName = lcfirst('SrcStorageName');
            $localValue = is_bool($request->src_storage_name) ? ($request->src_storage_name ? 'true' : 'false') : $request->src_storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->dest_storage_name !== null) {
            $localName = lcfirst('DestStorageName');
            $localValue = is_bool($request->dest_storage_name) ? ($request->dest_storage_name ? 'true' : 'false') : $request->dest_storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }


        $resourcePath = $this->_parseURL($resourcePath, $queryParams);

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json', 'application/xml']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json', 'application/xml'],
                ['application/json', 'application/xml']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                        'filename' => basename($filename)
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = $formParams["data"];
            }
        }

        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['x-aspose-client'] = $this->config->getUserAgent();
        }

        $defaultHeaders['x-aspose-client-version'] = $this->config->getClientVersion();

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $req = new Request(
            'PUT',
            $resourcePath,
            $headers,
            $httpBody
        );
        if ($this->config->getDebug()) {
            $this->_writeRequestLog('PUT', $resourcePath, $headers, $httpBody);
        }

        return $req;
    }

    /*
     * Operation createFolder
     *
     * Create the folder
     *
     * @param Requests\createFolderRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function createFolder(Requests\createFolderRequest $request)
    {
        try {
            $this->createFolderWithHttpInfo($request);
        } catch (RepeatRequestException $e) {
            $this->createFolderWithHttpInfo($request);
        }
    }

    /*
     * Operation createFolderWithHttpInfo
     *
     * Create the folder
     *
     * @param Requests\createFolderRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function createFolderWithHttpInfo(Requests\createFolderRequest $request)
    {
        $returnType = '';
        $request = $this->createFolderRequest($request);

        try {
            $options = $this->_createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                if ($statusCode === 401) {
                    $this->_requestToken();
                    throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                }

                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /*
     * Operation createFolderAsync
     *
     * Create the folder
     *
     * @param Requests\createFolderRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function createFolderAsync(Requests\createFolderRequest $request)
    {
        return $this->createFolderAsyncWithHttpInfo($request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /*
     * Operation createFolderAsyncWithHttpInfo
     *
     * Create the folder
     *
     * @param Requests\createFolderRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function createFolderAsyncWithHttpInfo(Requests\createFolderRequest $request)
    {
        $returnType = '';
        $request = $this->createFolderRequest($request);

        return $this->client
            ->sendAsync($request, $this->_createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($exception instanceof RepeatRequestException) {
                        $this->_refreshToken();
                        throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                    }

                    throw new ApiException(
                        sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody()
                    );
                }
            );
    }

    /*
     * Create request for operation 'createFolder'
     *
     * @param Requests\createFolderRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function createFolderRequest(Requests\createFolderRequest $request)
    {
        // verify the required parameter 'path' is set
        if ($request->path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $path when calling createFolder');
        }

        $resourcePath = '/assembly/storage/folder/{path}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = "";
        $multipart = false;

        // path params
        if ($request->path !== null) {
            $localName = lcfirst('Path');
            $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($request->path), $resourcePath);
        }

        // query params
        if ($request->storage_name !== null) {
            $localName = lcfirst('StorageName');
            $localValue = is_bool($request->storage_name) ? ($request->storage_name ? 'true' : 'false') : $request->storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }


        $resourcePath = $this->_parseURL($resourcePath, $queryParams);

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json', 'application/xml']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json', 'application/xml'],
                ['application/json', 'application/xml']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                        'filename' => basename($filename)
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = $formParams["data"];
            }
        }

        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['x-aspose-client'] = $this->config->getUserAgent();
        }

        $defaultHeaders['x-aspose-client-version'] = $this->config->getClientVersion();

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $req = new Request(
            'PUT',
            $resourcePath,
            $headers,
            $httpBody
        );
        if ($this->config->getDebug()) {
            $this->_writeRequestLog('PUT', $resourcePath, $headers, $httpBody);
        }

        return $req;
    }

    /*
     * Operation deleteFile
     *
     * Delete file
     *
     * @param Requests\deleteFileRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function deleteFile(Requests\deleteFileRequest $request)
    {
        try {
            $this->deleteFileWithHttpInfo($request);
        } catch (RepeatRequestException $e) {
            $this->deleteFileWithHttpInfo($request);
        }
    }

    /*
     * Operation deleteFileWithHttpInfo
     *
     * Delete file
     *
     * @param Requests\deleteFileRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function deleteFileWithHttpInfo(Requests\deleteFileRequest $request)
    {
        $returnType = '';
        $request = $this->deleteFileRequest($request);

        try {
            $options = $this->_createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                if ($statusCode === 401) {
                    $this->_requestToken();
                    throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                }

                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /*
     * Operation deleteFileAsync
     *
     * Delete file
     *
     * @param Requests\deleteFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function deleteFileAsync(Requests\deleteFileRequest $request)
    {
        return $this->deleteFileAsyncWithHttpInfo($request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /*
     * Operation deleteFileAsyncWithHttpInfo
     *
     * Delete file
     *
     * @param Requests\deleteFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function deleteFileAsyncWithHttpInfo(Requests\deleteFileRequest $request)
    {
        $returnType = '';
        $request = $this->deleteFileRequest($request);

        return $this->client
            ->sendAsync($request, $this->_createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($exception instanceof RepeatRequestException) {
                        $this->_refreshToken();
                        throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                    }

                    throw new ApiException(
                        sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody()
                    );
                }
            );
    }

    /*
     * Create request for operation 'deleteFile'
     *
     * @param Requests\deleteFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function deleteFileRequest(Requests\deleteFileRequest $request)
    {
        // verify the required parameter 'path' is set
        if ($request->path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $path when calling deleteFile');
        }

        $resourcePath = '/assembly/storage/file/{path}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = "";
        $multipart = false;

        // path params
        if ($request->path !== null) {
            $localName = lcfirst('Path');
            $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($request->path), $resourcePath);
        }

        // query params
        if ($request->storage_name !== null) {
            $localName = lcfirst('StorageName');
            $localValue = is_bool($request->storage_name) ? ($request->storage_name ? 'true' : 'false') : $request->storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->version_id !== null) {
            $localName = lcfirst('VersionId');
            $localValue = is_bool($request->version_id) ? ($request->version_id ? 'true' : 'false') : $request->version_id;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }


        $resourcePath = $this->_parseURL($resourcePath, $queryParams);

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json', 'application/xml']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json', 'application/xml'],
                ['application/json', 'application/xml']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                        'filename' => basename($filename)
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = $formParams["data"];
            }
        }

        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['x-aspose-client'] = $this->config->getUserAgent();
        }

        $defaultHeaders['x-aspose-client-version'] = $this->config->getClientVersion();

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $req = new Request(
            'DELETE',
            $resourcePath,
            $headers,
            $httpBody
        );
        if ($this->config->getDebug()) {
            $this->_writeRequestLog('DELETE', $resourcePath, $headers, $httpBody);
        }

        return $req;
    }

    /*
     * Operation deleteFolder
     *
     * Delete folder
     *
     * @param Requests\deleteFolderRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function deleteFolder(Requests\deleteFolderRequest $request)
    {
        try {
            $this->deleteFolderWithHttpInfo($request);
        } catch (RepeatRequestException $e) {
            $this->deleteFolderWithHttpInfo($request);
        }
    }

    /*
     * Operation deleteFolderWithHttpInfo
     *
     * Delete folder
     *
     * @param Requests\deleteFolderRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function deleteFolderWithHttpInfo(Requests\deleteFolderRequest $request)
    {
        $returnType = '';
        $request = $this->deleteFolderRequest($request);

        try {
            $options = $this->_createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                if ($statusCode === 401) {
                    $this->_requestToken();
                    throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                }

                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /*
     * Operation deleteFolderAsync
     *
     * Delete folder
     *
     * @param Requests\deleteFolderRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function deleteFolderAsync(Requests\deleteFolderRequest $request)
    {
        return $this->deleteFolderAsyncWithHttpInfo($request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /*
     * Operation deleteFolderAsyncWithHttpInfo
     *
     * Delete folder
     *
     * @param Requests\deleteFolderRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function deleteFolderAsyncWithHttpInfo(Requests\deleteFolderRequest $request)
    {
        $returnType = '';
        $request = $this->deleteFolderRequest($request);

        return $this->client
            ->sendAsync($request, $this->_createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($exception instanceof RepeatRequestException) {
                        $this->_refreshToken();
                        throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                    }

                    throw new ApiException(
                        sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody()
                    );
                }
            );
    }

    /*
     * Create request for operation 'deleteFolder'
     *
     * @param Requests\deleteFolderRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function deleteFolderRequest(Requests\deleteFolderRequest $request)
    {
        // verify the required parameter 'path' is set
        if ($request->path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $path when calling deleteFolder');
        }

        $resourcePath = '/assembly/storage/folder/{path}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = "";
        $multipart = false;

        // path params
        if ($request->path !== null) {
            $localName = lcfirst('Path');
            $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($request->path), $resourcePath);
        }

        // query params
        if ($request->storage_name !== null) {
            $localName = lcfirst('StorageName');
            $localValue = is_bool($request->storage_name) ? ($request->storage_name ? 'true' : 'false') : $request->storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->recursive !== null) {
            $localName = lcfirst('Recursive');
            $localValue = is_bool($request->recursive) ? ($request->recursive ? 'true' : 'false') : $request->recursive;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }


        $resourcePath = $this->_parseURL($resourcePath, $queryParams);

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json', 'application/xml']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json', 'application/xml'],
                ['application/json', 'application/xml']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                        'filename' => basename($filename)
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = $formParams["data"];
            }
        }

        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['x-aspose-client'] = $this->config->getUserAgent();
        }

        $defaultHeaders['x-aspose-client-version'] = $this->config->getClientVersion();

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $req = new Request(
            'DELETE',
            $resourcePath,
            $headers,
            $httpBody
        );
        if ($this->config->getDebug()) {
            $this->_writeRequestLog('DELETE', $resourcePath, $headers, $httpBody);
        }

        return $req;
    }

    /*
     * Operation downloadFile
     *
     * Download file
     *
     * @param Requests\downloadFileRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \SplFileObject
     */
    public function downloadFile(Requests\downloadFileRequest $request)
    {
        try {
            list($response) = $this->downloadFileWithHttpInfo($request);
            return $response;
        } catch (RepeatRequestException $e) {
            list($response) = $this->downloadFileWithHttpInfo($request);
            return $response;
        }
    }

    /*
     * Operation downloadFileWithHttpInfo
     *
     * Download file
     *
     * @param Requests\downloadFileRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \SplFileObject, HTTP status code, HTTP response headers (array of strings)
     */
    public function downloadFileWithHttpInfo(Requests\downloadFileRequest $request)
    {
        $returnType = '\SplFileObject';
        $request = $this->downloadFileRequest($request);

        try {
            $options = $this->_createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                if ($statusCode === 401) {
                    $this->_requestToken();
                    throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                }

                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            if ($this->config->getDebug()) {
                $this->_writeResponseLog($statusCode, $response->getHeaders(), ObjectSerializer::deserialize($content, $returnType, []));
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize($e->getResponseBody(), '\SplFileObject', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /*
     * Operation downloadFileAsync
     *
     * Download file
     *
     * @param Requests\downloadFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function downloadFileAsync(Requests\downloadFileRequest $request)
    {
        return $this->downloadFileAsyncWithHttpInfo($request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /*
     * Operation downloadFileAsyncWithHttpInfo
     *
     * Download file
     *
     * @param Requests\downloadFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function downloadFileAsyncWithHttpInfo(Requests\downloadFileRequest $request)
    {
        $returnType = '\SplFileObject';
        $request = $this->downloadFileRequest($request);

        return $this->client
            ->sendAsync($request, $this->_createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    if ($this->config->getDebug()) {
                        $this->_writeResponseLog($response->getStatusCode(), $response->getHeaders(), ObjectSerializer::deserialize($content, $returnType, []));
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($exception instanceof RepeatRequestException) {
                        $this->_refreshToken();
                        throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                    }

                    throw new ApiException(
                        sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody()
                    );
                }
            );
    }

    /*
     * Create request for operation 'downloadFile'
     *
     * @param Requests\downloadFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function downloadFileRequest(Requests\downloadFileRequest $request)
    {
        // verify the required parameter 'path' is set
        if ($request->path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $path when calling downloadFile');
        }

        $resourcePath = '/assembly/storage/file/{path}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = "";
        $multipart = false;

        // path params
        if ($request->path !== null) {
            $localName = lcfirst('Path');
            $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($request->path), $resourcePath);
        }

        // query params
        if ($request->storage_name !== null) {
            $localName = lcfirst('StorageName');
            $localValue = is_bool($request->storage_name) ? ($request->storage_name ? 'true' : 'false') : $request->storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->version_id !== null) {
            $localName = lcfirst('VersionId');
            $localValue = is_bool($request->version_id) ? ($request->version_id ? 'true' : 'false') : $request->version_id;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }


        $resourcePath = $this->_parseURL($resourcePath, $queryParams);

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json', 'application/xml']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json', 'application/xml'],
                ['application/json', 'application/xml']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                        'filename' => basename($filename)
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = $formParams["data"];
            }
        }

        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['x-aspose-client'] = $this->config->getUserAgent();
        }

        $defaultHeaders['x-aspose-client-version'] = $this->config->getClientVersion();

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $req = new Request(
            'GET',
            $resourcePath,
            $headers,
            $httpBody
        );
        if ($this->config->getDebug()) {
            $this->_writeRequestLog('GET', $resourcePath, $headers, $httpBody);
        }

        return $req;
    }

    /*
     * Operation getFilesList
     *
     * Get all files and folders within a folder
     *
     * @param Requests\getFilesListRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \GroupDocs\Assembly\Model\FilesList
     */
    public function getFilesList(Requests\getFilesListRequest $request)
    {
        try {
            list($response) = $this->getFilesListWithHttpInfo($request);
            return $response;
        } catch (RepeatRequestException $e) {
            list($response) = $this->getFilesListWithHttpInfo($request);
            return $response;
        }
    }

    /*
     * Operation getFilesListWithHttpInfo
     *
     * Get all files and folders within a folder
     *
     * @param Requests\getFilesListRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \GroupDocs\Assembly\Model\FilesList, HTTP status code, HTTP response headers (array of strings)
     */
    public function getFilesListWithHttpInfo(Requests\getFilesListRequest $request)
    {
        $returnType = '\GroupDocs\Assembly\Model\FilesList';
        $request = $this->getFilesListRequest($request);

        try {
            $options = $this->_createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                if ($statusCode === 401) {
                    $this->_requestToken();
                    throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                }

                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            if ($this->config->getDebug()) {
                $this->_writeResponseLog($statusCode, $response->getHeaders(), ObjectSerializer::deserialize($content, $returnType, []));
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize($e->getResponseBody(), '\GroupDocs\Assembly\Model\FilesList', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /*
     * Operation getFilesListAsync
     *
     * Get all files and folders within a folder
     *
     * @param Requests\getFilesListRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getFilesListAsync(Requests\getFilesListRequest $request)
    {
        return $this->getFilesListAsyncWithHttpInfo($request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /*
     * Operation getFilesListAsyncWithHttpInfo
     *
     * Get all files and folders within a folder
     *
     * @param Requests\getFilesListRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getFilesListAsyncWithHttpInfo(Requests\getFilesListRequest $request)
    {
        $returnType = '\GroupDocs\Assembly\Model\FilesList';
        $request = $this->getFilesListRequest($request);

        return $this->client
            ->sendAsync($request, $this->_createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    if ($this->config->getDebug()) {
                        $this->_writeResponseLog($response->getStatusCode(), $response->getHeaders(), ObjectSerializer::deserialize($content, $returnType, []));
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($exception instanceof RepeatRequestException) {
                        $this->_refreshToken();
                        throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                    }

                    throw new ApiException(
                        sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody()
                    );
                }
            );
    }

    /*
     * Create request for operation 'getFilesList'
     *
     * @param Requests\getFilesListRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getFilesListRequest(Requests\getFilesListRequest $request)
    {
        // verify the required parameter 'path' is set
        if ($request->path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $path when calling getFilesList');
        }

        $resourcePath = '/assembly/storage/folder/{path}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = "";
        $multipart = false;

        // path params
        if ($request->path !== null) {
            $localName = lcfirst('Path');
            $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($request->path), $resourcePath);
        }

        // query params
        if ($request->storage_name !== null) {
            $localName = lcfirst('StorageName');
            $localValue = is_bool($request->storage_name) ? ($request->storage_name ? 'true' : 'false') : $request->storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }


        $resourcePath = $this->_parseURL($resourcePath, $queryParams);

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json', 'application/xml']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json', 'application/xml'],
                ['application/json', 'application/xml']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                        'filename' => basename($filename)
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = $formParams["data"];
            }
        }

        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['x-aspose-client'] = $this->config->getUserAgent();
        }

        $defaultHeaders['x-aspose-client-version'] = $this->config->getClientVersion();

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $req = new Request(
            'GET',
            $resourcePath,
            $headers,
            $httpBody
        );
        if ($this->config->getDebug()) {
            $this->_writeRequestLog('GET', $resourcePath, $headers, $httpBody);
        }

        return $req;
    }

    /*
     * Operation getSupportedFileFormats
     *
     * Retrieves list of supported file formats.
     *
     * @param Requests\getSupportedFileFormatsRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \GroupDocs\Assembly\Model\FileFormatsResponse
     */
    public function getSupportedFileFormats(Requests\getSupportedFileFormatsRequest $request)
    {
        try {
            list($response) = $this->getSupportedFileFormatsWithHttpInfo($request);
            return $response;
        } catch (RepeatRequestException $e) {
            list($response) = $this->getSupportedFileFormatsWithHttpInfo($request);
            return $response;
        }
    }

    /*
     * Operation getSupportedFileFormatsWithHttpInfo
     *
     * Retrieves list of supported file formats.
     *
     * @param Requests\getSupportedFileFormatsRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \GroupDocs\Assembly\Model\FileFormatsResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function getSupportedFileFormatsWithHttpInfo(Requests\getSupportedFileFormatsRequest $request)
    {
        $returnType = '\GroupDocs\Assembly\Model\FileFormatsResponse';
        $request = $this->getSupportedFileFormatsRequest($request);

        try {
            $options = $this->_createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                if ($statusCode === 401) {
                    $this->_requestToken();
                    throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                }

                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            if ($this->config->getDebug()) {
                $this->_writeResponseLog($statusCode, $response->getHeaders(), ObjectSerializer::deserialize($content, $returnType, []));
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize($e->getResponseBody(), '\GroupDocs\Assembly\Model\FileFormatsResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /*
     * Operation getSupportedFileFormatsAsync
     *
     * Retrieves list of supported file formats.
     *
     * @param Requests\getSupportedFileFormatsRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getSupportedFileFormatsAsync(Requests\getSupportedFileFormatsRequest $request)
    {
        return $this->getSupportedFileFormatsAsyncWithHttpInfo($request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /*
     * Operation getSupportedFileFormatsAsyncWithHttpInfo
     *
     * Retrieves list of supported file formats.
     *
     * @param Requests\getSupportedFileFormatsRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getSupportedFileFormatsAsyncWithHttpInfo(Requests\getSupportedFileFormatsRequest $request)
    {
        $returnType = '\GroupDocs\Assembly\Model\FileFormatsResponse';
        $request = $this->getSupportedFileFormatsRequest($request);

        return $this->client
            ->sendAsync($request, $this->_createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    if ($this->config->getDebug()) {
                        $this->_writeResponseLog($response->getStatusCode(), $response->getHeaders(), ObjectSerializer::deserialize($content, $returnType, []));
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($exception instanceof RepeatRequestException) {
                        $this->_refreshToken();
                        throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                    }

                    throw new ApiException(
                        sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody()
                    );
                }
            );
    }

    /*
     * Create request for operation 'getSupportedFileFormats'
     *
     * @param Requests\getSupportedFileFormatsRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getSupportedFileFormatsRequest(Requests\getSupportedFileFormatsRequest $request)
    {

        $resourcePath = '/assembly/formats';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = "";
        $multipart = false;


        $resourcePath = $this->_parseURL($resourcePath, $queryParams);

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json', 'application/xml']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json', 'application/xml'],
                ['application/json', 'application/xml']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                        'filename' => basename($filename)
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = $formParams["data"];
            }
        }

        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['x-aspose-client'] = $this->config->getUserAgent();
        }

        $defaultHeaders['x-aspose-client-version'] = $this->config->getClientVersion();

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $req = new Request(
            'GET',
            $resourcePath,
            $headers,
            $httpBody
        );
        if ($this->config->getDebug()) {
            $this->_writeRequestLog('GET', $resourcePath, $headers, $httpBody);
        }

        return $req;
    }

    /*
     * Operation moveFile
     *
     * Move file
     *
     * @param Requests\moveFileRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function moveFile(Requests\moveFileRequest $request)
    {
        try {
            $this->moveFileWithHttpInfo($request);
        } catch (RepeatRequestException $e) {
            $this->moveFileWithHttpInfo($request);
        }
    }

    /*
     * Operation moveFileWithHttpInfo
     *
     * Move file
     *
     * @param Requests\moveFileRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function moveFileWithHttpInfo(Requests\moveFileRequest $request)
    {
        $returnType = '';
        $request = $this->moveFileRequest($request);

        try {
            $options = $this->_createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                if ($statusCode === 401) {
                    $this->_requestToken();
                    throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                }

                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /*
     * Operation moveFileAsync
     *
     * Move file
     *
     * @param Requests\moveFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function moveFileAsync(Requests\moveFileRequest $request)
    {
        return $this->moveFileAsyncWithHttpInfo($request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /*
     * Operation moveFileAsyncWithHttpInfo
     *
     * Move file
     *
     * @param Requests\moveFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function moveFileAsyncWithHttpInfo(Requests\moveFileRequest $request)
    {
        $returnType = '';
        $request = $this->moveFileRequest($request);

        return $this->client
            ->sendAsync($request, $this->_createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($exception instanceof RepeatRequestException) {
                        $this->_refreshToken();
                        throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                    }

                    throw new ApiException(
                        sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody()
                    );
                }
            );
    }

    /*
     * Create request for operation 'moveFile'
     *
     * @param Requests\moveFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function moveFileRequest(Requests\moveFileRequest $request)
    {
        // verify the required parameter 'dest_path' is set
        if ($request->dest_path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $dest_path when calling moveFile');
        }
        // verify the required parameter 'src_path' is set
        if ($request->src_path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $src_path when calling moveFile');
        }

        $resourcePath = '/assembly/storage/file/move/{srcPath}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = "";
        $multipart = false;

        // path params
        if ($request->src_path !== null) {
            $localName = lcfirst('SrcPath');
            $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($request->src_path), $resourcePath);
        }

        // query params
        if ($request->dest_path !== null) {
            $localName = lcfirst('DestPath');
            $localValue = is_bool($request->dest_path) ? ($request->dest_path ? 'true' : 'false') : $request->dest_path;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->src_storage_name !== null) {
            $localName = lcfirst('SrcStorageName');
            $localValue = is_bool($request->src_storage_name) ? ($request->src_storage_name ? 'true' : 'false') : $request->src_storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->dest_storage_name !== null) {
            $localName = lcfirst('DestStorageName');
            $localValue = is_bool($request->dest_storage_name) ? ($request->dest_storage_name ? 'true' : 'false') : $request->dest_storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->version_id !== null) {
            $localName = lcfirst('VersionId');
            $localValue = is_bool($request->version_id) ? ($request->version_id ? 'true' : 'false') : $request->version_id;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }


        $resourcePath = $this->_parseURL($resourcePath, $queryParams);

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json', 'application/xml']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json', 'application/xml'],
                ['application/json', 'application/xml']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                        'filename' => basename($filename)
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = $formParams["data"];
            }
        }

        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['x-aspose-client'] = $this->config->getUserAgent();
        }

        $defaultHeaders['x-aspose-client-version'] = $this->config->getClientVersion();

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $req = new Request(
            'PUT',
            $resourcePath,
            $headers,
            $httpBody
        );
        if ($this->config->getDebug()) {
            $this->_writeRequestLog('PUT', $resourcePath, $headers, $httpBody);
        }

        return $req;
    }

    /*
     * Operation moveFolder
     *
     * Move folder
     *
     * @param Requests\moveFolderRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function moveFolder(Requests\moveFolderRequest $request)
    {
        try {
            $this->moveFolderWithHttpInfo($request);
        } catch (RepeatRequestException $e) {
            $this->moveFolderWithHttpInfo($request);
        }
    }

    /*
     * Operation moveFolderWithHttpInfo
     *
     * Move folder
     *
     * @param Requests\moveFolderRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function moveFolderWithHttpInfo(Requests\moveFolderRequest $request)
    {
        $returnType = '';
        $request = $this->moveFolderRequest($request);

        try {
            $options = $this->_createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                if ($statusCode === 401) {
                    $this->_requestToken();
                    throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                }

                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /*
     * Operation moveFolderAsync
     *
     * Move folder
     *
     * @param Requests\moveFolderRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function moveFolderAsync(Requests\moveFolderRequest $request)
    {
        return $this->moveFolderAsyncWithHttpInfo($request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /*
     * Operation moveFolderAsyncWithHttpInfo
     *
     * Move folder
     *
     * @param Requests\moveFolderRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function moveFolderAsyncWithHttpInfo(Requests\moveFolderRequest $request)
    {
        $returnType = '';
        $request = $this->moveFolderRequest($request);

        return $this->client
            ->sendAsync($request, $this->_createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($exception instanceof RepeatRequestException) {
                        $this->_refreshToken();
                        throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                    }

                    throw new ApiException(
                        sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody()
                    );
                }
            );
    }

    /*
     * Create request for operation 'moveFolder'
     *
     * @param Requests\moveFolderRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function moveFolderRequest(Requests\moveFolderRequest $request)
    {
        // verify the required parameter 'dest_path' is set
        if ($request->dest_path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $dest_path when calling moveFolder');
        }
        // verify the required parameter 'src_path' is set
        if ($request->src_path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $src_path when calling moveFolder');
        }

        $resourcePath = '/assembly/storage/folder/move/{srcPath}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = "";
        $multipart = false;

        // path params
        if ($request->src_path !== null) {
            $localName = lcfirst('SrcPath');
            $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($request->src_path), $resourcePath);
        }

        // query params
        if ($request->dest_path !== null) {
            $localName = lcfirst('DestPath');
            $localValue = is_bool($request->dest_path) ? ($request->dest_path ? 'true' : 'false') : $request->dest_path;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->src_storage_name !== null) {
            $localName = lcfirst('SrcStorageName');
            $localValue = is_bool($request->src_storage_name) ? ($request->src_storage_name ? 'true' : 'false') : $request->src_storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }
        // query params
        if ($request->dest_storage_name !== null) {
            $localName = lcfirst('DestStorageName');
            $localValue = is_bool($request->dest_storage_name) ? ($request->dest_storage_name ? 'true' : 'false') : $request->dest_storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }


        $resourcePath = $this->_parseURL($resourcePath, $queryParams);

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json', 'application/xml']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json', 'application/xml'],
                ['application/json', 'application/xml']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                        'filename' => basename($filename)
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = $formParams["data"];
            }
        }

        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['x-aspose-client'] = $this->config->getUserAgent();
        }

        $defaultHeaders['x-aspose-client-version'] = $this->config->getClientVersion();

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $req = new Request(
            'PUT',
            $resourcePath,
            $headers,
            $httpBody
        );
        if ($this->config->getDebug()) {
            $this->_writeRequestLog('PUT', $resourcePath, $headers, $httpBody);
        }

        return $req;
    }

    /*
     * Operation uploadFile
     *
     * Upload file
     *
     * @param Requests\uploadFileRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \GroupDocs\Assembly\Model\FilesUploadResult
     */
    public function uploadFile(Requests\uploadFileRequest $request)
    {
        try {
            list($response) = $this->uploadFileWithHttpInfo($request);
            return $response;
        } catch (RepeatRequestException $e) {
            list($response) = $this->uploadFileWithHttpInfo($request);
            return $response;
        }
    }

    /*
     * Operation uploadFileWithHttpInfo
     *
     * Upload file
     *
     * @param Requests\uploadFileRequest $request is a request object for operation
     *
     * @throws \GroupDocs\Assembly\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \GroupDocs\Assembly\Model\FilesUploadResult, HTTP status code, HTTP response headers (array of strings)
     */
    public function uploadFileWithHttpInfo(Requests\uploadFileRequest $request)
    {
        $returnType = '\GroupDocs\Assembly\Model\FilesUploadResult';
        $request = $this->uploadFileRequest($request);

        try {
            $options = $this->_createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? $e->getResponse()->getBody() : null);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                if ($statusCode === 401) {
                    $this->_requestToken();
                    throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                }

                throw new ApiException(sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()), $statusCode, $response->getHeaders(), $response->getBody());
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            if ($this->config->getDebug()) {
                $this->_writeResponseLog($statusCode, $response->getHeaders(), ObjectSerializer::deserialize($content, $returnType, []));
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize($e->getResponseBody(), '\GroupDocs\Assembly\Model\FilesUploadResult', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /*
     * Operation uploadFileAsync
     *
     * Upload file
     *
     * @param Requests\uploadFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function uploadFileAsync(Requests\uploadFileRequest $request)
    {
        return $this->uploadFileAsyncWithHttpInfo($request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /*
     * Operation uploadFileAsyncWithHttpInfo
     *
     * Upload file
     *
     * @param Requests\uploadFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function uploadFileAsyncWithHttpInfo(Requests\uploadFileRequest $request)
    {
        $returnType = '\GroupDocs\Assembly\Model\FilesUploadResult';
        $request = $this->uploadFileRequest($request);

        return $this->client
            ->sendAsync($request, $this->_createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    if ($this->config->getDebug()) {
                        $this->_writeResponseLog($response->getStatusCode(), $response->getHeaders(), ObjectSerializer::deserialize($content, $returnType, []));
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();

                    if ($exception instanceof RepeatRequestException) {
                        $this->_refreshToken();
                        throw new RepeatRequestException("Request must be retried", $statusCode, $response->getHeaders(), $response->getBody());
                    }

                    throw new ApiException(
                        sprintf('[%d] Error connecting to the API (%s)', $statusCode, $exception->getRequest()->getUri()), $statusCode, $response->getHeaders(), $response->getBody()
                    );
                }
            );
    }

    /*
     * Create request for operation 'uploadFile'
     *
     * @param Requests\uploadFileRequest $request is a request object for operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function uploadFileRequest(Requests\uploadFileRequest $request)
    {
        // verify the required parameter 'file' is set
        if ($request->file === null) {
            throw new \InvalidArgumentException('Missing the required parameter $file when calling uploadFile');
        }
        // verify the required parameter 'path' is set
        if ($request->path === null) {
            throw new \InvalidArgumentException('Missing the required parameter $path when calling uploadFile');
        }

        $resourcePath = '/assembly/storage/file/{path}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = "";
        $multipart = false;

        // path params
        if ($request->path !== null) {
            $localName = lcfirst('Path');
            $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($request->path), $resourcePath);
        }

        // query params
        if ($request->storage_name !== null) {
            $localName = lcfirst('StorageName');
            $localValue = is_bool($request->storage_name) ? ($request->storage_name ? 'true' : 'false') : $request->storage_name;
            if (strpos($resourcePath, '{' . $localName . '}') !== false) {
                $resourcePath = str_replace('{' . $localName . '}', ObjectSerializer::toPathValue($localValue), $resourcePath);
            } else {
                $queryParams[$localName] = ObjectSerializer::toQueryValue($localValue);
            }
        }


        $resourcePath = $this->_parseURL($resourcePath, $queryParams);

        // form params
        if ($request->file !== null) {
            $multipart = true;
            $filename = ObjectSerializer::toFormValue($request->file);
            $handle = fopen($filename, "rb");
            $fsize = filesize($filename);
            $contents = fread($handle, $fsize);
            $formParams['file'] = $contents;
        }
        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json', 'application/xml']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json', 'application/xml'],
                ['multipart/form-data']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                        'filename' => basename($filename)
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = $formParams["data"];
            }
        }

        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['x-aspose-client'] = $this->config->getUserAgent();
        }

        $defaultHeaders['x-aspose-client-version'] = $this->config->getClientVersion();

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $req = new Request(
            'PUT',
            $resourcePath,
            $headers,
            $httpBody
        );
        if ($this->config->getDebug()) {
            $this->_writeRequestLog('PUT', $resourcePath, $headers, $httpBody);
        }

        return $req;
    }

    /*
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    private function _createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }

    /*
     * Executes response logging
     */
    private function _writeResponseLog($statusCode, $headers, $body)
    {
        $logInfo = "\nResponse: $statusCode \n";
        echo $logInfo . $this->_writeHeadersAndBody($logInfo, $headers, $body);
    }

    /*
     * Executes request logging
     */
    private function _writeRequestLog($method, $url, $headers, $body)
    {
        $logInfo = "\n$method: $url \n";
        echo $logInfo . $this->_writeHeadersAndBody($logInfo, $headers, $body);
    }

    /*
     * Executes header and boy formatting
     */
    private function _writeHeadersAndBody($logInfo, $headers, $body)
    {
        foreach ($headers as $name => $value) {
            $logInfo .= $name . ': ' . $value . "\n";
        }

        return $logInfo .= "Body: " . $body . "\n";
    }

    /*
     * Executes url parsing
     */
    private function _parseURL($url, $queryParams)
    {
        $urlQuery = http_build_query($queryParams);
        return $this->config->getHost() . $this->config->getBasePath() . $url . "?" . $urlQuery;
    }

    /*
     * Gets a request token from server
     */
    private function _requestToken()
    {
        $requestUrl = $this->config->getHost() . "connect/token";
        $params = array(
            "grant_type" => 'client_credentials',
            "client_id" => $this->config->getAppSid(),
            "client_secret" => $this->config->getAppKey()
        );
        $multipartContents = [];
        foreach ($params as $paramName => $paramValue) {
            $multipartContents[] = [
                'name' => $paramName,
                'contents' => $paramValue
            ];
        }
        // for HTTP post (form)
        $httpBody = new MultipartStream($multipartContents);
        $response = $this->client->send(new Request('POST', $requestUrl, [], $httpBody));
        $result = json_decode($response->getBody()->getContents(), true);
        $this->config->setAccessToken($result["access_token"]);
    }
}