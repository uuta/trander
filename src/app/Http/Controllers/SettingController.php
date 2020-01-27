<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SettingRepository;
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
    $setting = $this->SettingRepository->getSetting();
    return $setting;
  }
}
