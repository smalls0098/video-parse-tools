<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Traits;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 22:05
 **/
trait HttpRequest
{

    //基础URL
    private $baseUri;

    //超时时间
    private $timeout;

    /**
     * 公共GET方法
     * @param $url
     * @param array $query
     * @param array $headers
     * @return mixed|string
     */
    public function get(string $url = '', array $query = [], array $headers = [])
    {
        $params = [
            'headers' => $headers,
            'query'   => $query,
        ];
        if ($this->isProxy) {
            $params['proxy'] = [
                'http'  => $this->proxyIpPort,
                'https' => $this->proxyIpPort,
            ];
        }
        return $this->request('get', $url, $params);
    }

    /**
     * 公共POST方法
     * @param $url
     * @param $data
     * @param array $headers
     * @return mixed|string
     */
    public function post(string $url = '', array $data = [], array $headers = [])
    {
        $options = [
            'headers' => $headers,
        ];

        if (!is_array($data)) {
            $options['body'] = $data;
        } else {
            $options['form_params'] = $data;
        }

        return $this->request('post', $url, $options);
    }

    /**
     * 公共POST方法
     * @param $url
     * @param array $query
     * @param array $headers
     * @return mixed|string
     */
    public function getCookie(string $url = '', array $query = [], array $headers = [])
    {
        $params = [
            'headers' => $headers,
            'query'   => $query,
        ];
        if ($this->isProxy) {
            $params['proxy'] = [
                'http'  => $this->proxyIpPort,
                'https' => $this->proxyIpPort,
            ];
        }
        $response = $this->getHttpClient($this->getBaseOptions())->get($url, [
            'headers' => $headers,
            'query'   => $query,
        ]);
        return $response->getHeaderLine('set-Cookie');
    }

    /**
     * 公共GET方法
     * @param $url
     * @param array $query
     * @param array $headers
     * @param bool $isAllReturn
     * @return mixed|string
     */
    public function redirects($url, $query = [], $headers = [], $isAllReturn = false)
    {
        $response = $this->getHttpClient($this->getBaseOptions())->get($url, [
            'headers'         => $headers,
            'query'           => $query,
            'allow_redirects' => false,
        ]);
        if (substr((string)$response->getStatusCode(), 0, 2) === '30') {
            $headers = $response->getHeaders();
            if ($isAllReturn) {
                return $headers;
            }
            if (isset($headers['location'][0])) {
                return $headers['location'][0];
            }
            if (isset($headers['Location'][0])) {
                return $headers['Location'][0];
            }
            return "";
        }
        return "";
    }

    public function getBaseOptions()
    {
        $options = [
            'base_uri' => property_exists($this, 'baseUri') ? $this->baseUri : '',
            'timeout'  => property_exists($this, 'timeout') ? $this->timeout : 5.0,
            'verify'   => false,
        ];
        return $options;
    }

    /**
     * 创建一个客户端
     * @param array $options
     * @return Client
     */
    public function getHttpClient(array $options = [])
    {
        return new Client($options);
    }

    /**
     * 公共请求方法
     * @param $method string 方法 | GET | POST
     * @param $url string url
     * @param array $params array 参数
     * @return mixed|string
     */
    public function request($method, $url, $params = [])
    {
        return $this->unwrapResponse($this->getHttpClient($this->getBaseOptions())->{$method}($url, $params));
    }

    public function unwrapResponse(ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        $contents    = $response->getBody()->getContents();
        if (false !== stripos($contentType, 'json') || stripos($contentType, 'javascript')) {
            return json_decode($contents, true);
        } elseif (false !== stripos($contentType, 'xml')) {
            return json_decode(json_encode(simplexml_load_string($contents, 'SimpleXMLElement', LIBXML_NOCDATA), JSON_UNESCAPED_UNICODE), true);
        }
        return $contents;
    }

}