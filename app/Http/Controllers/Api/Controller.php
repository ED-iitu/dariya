<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    public function __construct(Request $request)
    {
        if($request->header('Authorization')){
            $this->middleware("auth:sanctum");
        }
    }

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
        if(empty($error)){
            $error = 'Не известная ошибка!';
        }
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