<?php

namespace App\Http\Traits;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

trait VerifiedMagicLoginToken
{
    public function verify(string $identifier, string $magic_login_token)
    {
        DB::beginTransaction();
        try {

            $query = DB::connection('mysql_crmv2')->table('magic_login_token')->where('identifier', $identifier)->where('used', 0);
            if (!$magic_login = $query->first())
            {
                throw new HttpResponseException(
                    response()->json([
                        'message' => "Invalid token.",
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
                );
            }


            if ( Hash::check($magic_login->issued_token, $magic_login_token) )
            {
                throw new HttpResponseException(
                    response()->json([
                        'message' => "Unverified.",
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
                );
            }
    
            $query->update(['used' => 1, 'updated_at' => Carbon::now()]);
            DB::commit();
        } catch (Exception $err) {
            DB::rollBack();
            Log::emergency('[VERIFY SAFE URL] Failed to verify safe url. Error: '. $err->getMessage() .' on '. $err->getFile() .' line '. $err->getLine());
            throw new HttpResponseException(
                response()->json([
                    'error' => 'Something went wrong when try to logging in. Please try again or contact our administrator.'
                ])
            );
        }

    }
}
