<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeneralSettingService;
use App\Models\GeneralSetting;

class GeneralSettingController extends Controller
{
    private $generalSettingService;

    public function __construct(GeneralSettingService $generalSettingService)
    {
        $this->generalSettingService = $generalSettingService;
    }
    public function index()
    {
        return $this->generalSettingService->listSettings();
    }

    public function create()
    {
        return $this->generalSettingService->createSetting();
    }

    public function store(Request $request)
    {
        return $this->generalSettingService->storeSetting($request);
    }

    public function show(GeneralSetting $setting)
    {
        return $this->generalSettingService->showSetting($setting);
    }

    public function edit(GeneralSetting $setting)
    {
        return $this->generalSettingService->editSetting($setting);
    }

    public function update(Request $request, GeneralSetting $setting)
    {
        return $this->generalSettingService->updateSetting($request, $setting);
    }

    public function destroy(GeneralSetting $setting)
    {
        return $this->generalSettingService->destroyEquipment($setting);
    }
}
