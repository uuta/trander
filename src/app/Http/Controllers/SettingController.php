<?php

namespace App\Http\Controllers;

use App\Repositories\SettingRepository;
use App\Http\Controllers\Controller;
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

  public function store(Request $request)
  {
    Log::debug($request);
    $this->SettingRepository->setSetting($request);
  }
}
