<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use App\Exceptions\ErroGeralException;

class AdminController extends Controller
{
    protected $service;
    public function __construct()
    {
        $this->service = new AdminService();
    }
    public function login(Request $request)
    {
        try {
            return $this->service->login($request);
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
