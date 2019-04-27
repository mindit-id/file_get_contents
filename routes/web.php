<?php
use Illuminate\Http\Request;


use \GuzzleHttp\Client;
use \GuzzleHttp\Ps7;
use \GuzzleHttp\Exception\RequestExeption;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('/file_get_contents', function (Request $request) use ($router) {
    $url = $request->url;
    return file_get_contents($url);
});
$router->post('/file_get_contents_zippyshare', function (Request $request) use ($router){
    $url = $request->url;
    $method = $request->method;
    $params = [
        'page' => $request->page,
        'user' => $request->user,
        'dir' => $request->dir,
        'sort' => $request->sort,
        'pageSize' => $request->pageSize,
        'search' => $request->search,
        'viewType' => $request->search
    ];
    $client = new Client(['base_uri' => $url, 'decode_content' => false]);
    try{
        switch($method){
            default:
            case 'GET':
                if($params==null){
                    $response = $client->request('GET', '', ['json' => $params]);
                }
                else{
                    $response = $client->request('GET', ''.'?'.http_build_query($params));
                }
                break;
            case 'POST':
                $response = $client->request('POST', '', ['json' => $params]);
                break;
        }
        $status_code = $response->getStatusCode();
        if($status_code == 200){
            return $response->getBody();
            // return json_decode($response->getBody()->getContents(), true);
        }
        else{
            return $response;
        }
    }
    catch(RequestExeption $e){
        if($e->hasResponse()){
            return json_decode($e->getResponse()->getBody()->getContent(), true);
        }
        return false;
    }
});
$router->post('/file_get_contents_uptobox', function (Request $request) use ($router){
    $url = $request->url;
    $method = $request->method;
    $params = [
        'folder' => $request->folder,
        'hash' => $request->hash,
        'orderBy' => $request->orderBy,
        'dir'   => $request->dir,
        'offset' => $request->offset,
        'limit' => $request->limit
    ];
    $client = new Client(['base_uri' => $url, 'decode_content' => false]);
    try{
        switch($method){
            default:
            case 'GET':
                if($params==null){
                    $response = $client->request('GET', '', ['json' => $params]);
                }
                else{
                    $response = $client->request('GET', ''.'?'.http_build_query($params));
                }
                break;
            case 'POST':
                $response = $client->request('POST', '', ['json' => $params]);
                break;
        }
        $status_code = $response->getStatusCode();
        if($status_code == 200){
            return $response->getBody();
            // return json_decode($response->getBody()->getContents(), true);
        }
        else{
            return $response;
        }
    }
    catch(RequestExeption $e){
        if($e->hasResponse()){
            return json_decode($e->getResponse()->getBody()->getContent(), true);
        }
        return false;
    }
});
