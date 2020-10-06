<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller as BaseController;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Monolog\Formatter\JsonFormatter;
use PhpParser\JsonDecoder;
use Psy\Util\Json;

class Controller extends BaseController
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    public function getParsedBody($name = null){
        $request = Request::createFromGlobals();
        if($content = $request->getContent()){
            $content = json_decode($content, true);
            if($name && !empty($content) && isset($content[$name])){
                return $content[$name];
            }
            return $content;
        }
        return null;
    }
}