<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MovieService
{
  protected $apiKey;
  protected $baseUrl = 'http://www.omdbapi.com/';

  public function __construct()
  {
    $this->apiKey = config('services.omdb.key');
  }

  public function search($query, $page = 1)
  {
    $response = Http::get($this->baseUrl, [
      'apikey' => $this->apiKey,
      's' => $query,
      'page' => $page,
    ]);

    return $response->json();
  }

  public function getDetail($id)
  {
    $response = Http::get($this->baseUrl, [
      'apikey' => $this->apiKey,
      'i' => $id,
      'plot' => 'full',
    ]);

    return $response->json();
  }
}
