<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        return response()->json($this->serviceService->getAllServices());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        $service = $this->serviceService->createService($data);
        return response()->json($service, 201);
    }

    public function show($id)
    {
        return response()->json($this->serviceService->findService($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        $service = $this->serviceService->updateService($id, $data);
        return response()->json($service);
    }

    public function destroy($id)
    {
        $this->serviceService->deleteService($id);
        return response()->json(null, 204);
    }
}
