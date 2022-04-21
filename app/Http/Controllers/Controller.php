<?php

namespace App\Http\Controllers;

use App\Support\Actions\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Response;

    protected int $code = 400;

    protected string $message = 'error load data';

    protected string $info = '';

    protected array $body = [];

}
