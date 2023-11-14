<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    private $statusValues = [
        'authorised' => [1, 100],
        'decline' => [2, 200],
        'refunded' => [3, 300],
    ];


    /*
    *    it should list all users which combine transactaions from all the available providerDataProviderX and DataProviderY )
    *    it should be able to filter resullt by payment providers for example /api/v1/users?provider=DataProviderX it should return users from DataProviderX
    *    it should be able to filter result three statusCode (authorised, decline, refunded) for example /api/v1/users?statusCode=authorised it should return all users from all providers that have status code authorised
    *    it should be able to filer by amount range for example /api/v1/users?balanceMin=10&balanceMax=100 it should return result between 10 and 100 including 10 and 100
    *    it should be able to filer by currency
    *    it should be able to combine all this filter together
    */
    public function index(Request $request)
    {
        $files = collect(File::files(base_path('providers')));
        if ($request->has('provider')){
            $files = $files->filter(fn($file)=> strtolower($file->getBasename('.json')) == strtolower($request->provider));
        }
        $cache_key = md5(implode('', $files->map(fn($file)=> $file->getFilename().$file->getMTime())->toArray()));
        $data = Cache::remember($cache_key, 3600, function() use($files) {
            return $files->map(fn($file)=> File::json($file))->flatten(1);
        });

        $data = $data->filter(function($item) use($request){
            $amountVal = $item['balance'] ?? ($item['parentAmount'] ?? 0);
            $currencyVal = $item['currency'] ?? ($item['Currency'] ?? '');
            if (
                (
                    $request->has('statusCode') && (
                    (isset($item['statusCode']) && !in_array($item['statusCode'], $this->statusValues[$request->statusCode])) ||
                        (isset($item['status']) && !in_array($item['status'], $this->statusValues[$request->statusCode]))
                    )
                )
                || ($request->has('balanceMin') && $request->balanceMin > $amountVal)
                || ($request->has('balanceMax') && $request->balanceMax < $amountVal)
                || ($request->has('currency') && $currencyVal != $request->currency)
            ) {
                return false;
            }
            return true;
        });

        return UserResource::collection($data);
    }
}
