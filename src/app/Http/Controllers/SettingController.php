<?php

namespace App\Http\Controllers;

use App\Repositories\SettingRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
  protected $SettingRepository;

  public function __construct(SettingRepository $SettingRepository)
  {
    $this->SettingRepository = $SettingRepository;
  }

  public function request()
  {
    $response = $this->SettingRepository->getSetting();
    $response_json = response()->json($response);
    return $response_json;
  }
}
