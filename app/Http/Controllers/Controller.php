<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\ErrorLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($result, $message, $request, $route)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        $log = $this->createLog($response, $request, $route);

        $this->accessLog($log);

        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $request, $route, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        $log = $this->createLog($response, $request, $route);

        $this->accessLog($log);

        return response()->json($response, $code);
    }

    private function accessLog($data){
        $log = new AccessLog();
        $log->method = $data->method;
        $log->controller = $data->controller;
        $log->function = $data->function;
        $log->request = $data->request;
        $log->response = $data->response;
        $log->ip_address = $data->ip;
        $log->save();
    }

    private function errorLog($data){
        $log = new ErrorLog();
        $log->method = $data->method;
        $log->controller = $data->controller;
        $log->function = $data->function;
        $log->request = $data->request;
        $log->response = $data->response;
        $log->ip_address = $data->ip_adress;
        $log->save();
    }

    private function createLog($data, $request, $route){
        $action_exp = explode('@', $route->getActionName());

        $log = new \stdClass();
        $log->method = $request->method();
        $log->controller = $action_exp[0];
        $log->function = $action_exp[1];
        $log->request = $request->url();
        $log->response = json_encode($data);
        $log->ip = $request->ip();

        return $log;
    }
}
