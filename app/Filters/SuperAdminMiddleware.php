<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SuperAdminMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logado')) {
            return redirect()->to('login');
        }

        if ((session()->get('user')['tipo'] ?? null) !== 'super_admin') {
            return redirect()->to('401');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
