<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseJSON extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      Response::macro('success', function ($data){
        return response()->json([
            'error' => false,
            'data' => $data
        ]);
      });

      Response::macro('error', function ($message, $status = 422, $additional_info = []){
        return response()->json([
            'error' => true,
            'data' => [
              'message' => $message,
              'info' => $additional_info,
              'code' => $status
            ]
        ]);
      });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
