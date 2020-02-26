<?php

namespace App\Http\Controllers;

use App\Repositories\CheckRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckController extends Controller
{
  protected $CheckRepository;

  public function __construct(CheckRepository $CheckRepository)
  {
    $this->CheckRepository = $CheckRepository;
  }

  public function changeRegistration()
  {
    $this->CheckRepository->changeRegistration();
  }
}
