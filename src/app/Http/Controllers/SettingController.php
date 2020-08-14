<?php

namespace App\Http\Controllers;

use App\Repositories\SettingRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostSettingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    protected $SettingRepository;

    public function __construct(SettingRepository $SettingRepository)
    {
        $this->SettingRepository = $SettingRepository;
    }

    public function get()
    {
        $response = $this->SettingRepository->getSetting();
        $response_json = response()->json($response);
        return $response_json;
    }

    public function store(PostSettingRequest $request)
    {
        try
        {
            DB::transaction(function () use ($request) {
                $this->SettingRepository->setSetting($request);
            });
        }
        catch(\Exception $e)
        {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }
}
