<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class ResponseMiddleware
{
    const OK = 200, NOCONTENT = 204, ACCESSDENIED = '400.1', BADREQUEST = 400, INVALIDJSON = 551, UNAUTHORIZED = 401, FORBIDDEN = 403, NOTFOUND = 404, METHODNOTALLOWED = 405, SESSIONEXPIRED = 419, INTERNALSERVERERROR = 500, NOTIMPLEMENTED = 501;



    public  $messageByErrorcode = [
        self::INVALIDJSON => "Invalid json format, Please correct your request json format.",
        self::UNAUTHORIZED => "Access Denied. Unauthorized Request",
        self::ACCESSDENIED => "Access Denied. Please make sure you configure route correctly",
        self::NOCONTENT => "",
        self::BADREQUEST => "",
        self::FORBIDDEN => "Forbidden",
        self::NOTFOUND => "Not Found",
        self::METHODNOTALLOWED => "Method Not Allowed",
        self::SESSIONEXPIRED => "Session Expired! Please login again",
        self::INTERNALSERVERERROR => "Internal Server Error",
        self::OK => "Successfull",


    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Pre-Middleware Action
        $response = $next($request);
        // dd($response);

        // Post-Middleware Action
        //********** Saving Response ***********//
        $responseJson = $response->content();
        $statusCode = $response->status();
        $responseArray = json_decode($responseJson);
        

        $others = [];
        if (isset($responseArray->trace)) {
            $others = $responseArray->trace;
        }

        if (isset($responseArray->error) && $responseArray->error == 1) {
            if ($statusCode > 0) {
                $statusCode = $statusCode;
            } else {
                // for validation errors or success
                $statusCode = self::OK;
            }
            // dd($statusCode);


            $messageToSend = $responseArray->message;
            $responseToSend = $this->createErrorResponse($statusCode, $messageToSend, $response);
        } else {
            if ($statusCode == 200) {
                $responseToSend = $this->createSuccessResponse($responseArray, $response);
            } else {

                $messageToSend = $responseArray;

                $responseToSend = $this->createErrorResponse($statusCode, $messageToSend, $response);
            }
        }
        return $response;
    }
    private function createErrorResponse($code, $message = null, $response)
    {
        if ($message) {
            $messageToSend = $message;
        } else {
            $messageToSend = $this->messageByErrorcode[$code];
        }
        $data = [
            'OK' => 0,
            'status' => 'ERROR',
            'code' => $code,
            'message' => $messageToSend,
        ];
        return $this->setResponse($data, $response);
    }

    private function createSuccessResponse($responseArray, $response)
    {
        $data = [
            'OK' => 1,
            'status' => 'OK',
            'code' => self::OK,
            'message' => isset($responseArray->message) ? $responseArray->message : [],
            'data' => isset($responseArray->data) ? $responseArray->data : []
        ];
        return $this->setResponse($data, $response);
    }

    private function setResponse($data, $response)
    {
        if ($response instanceof JsonResponse) {
            $response->setData($data);
        } else {
            $response->setContent($data);
        }
    }
}
