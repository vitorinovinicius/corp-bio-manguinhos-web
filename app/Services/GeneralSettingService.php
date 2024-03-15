<?php

    namespace App\Services;

    use App\Repositories\GeneralSettingRepository;
    use Illuminate\Http\Request;

    class GeneralSettingService
    {
        private $generalSettingRepository;

        public function __construct(GeneralSettingRepository $generalSettingRepository)
        {
            $this->generalSettingRepository = $generalSettingRepository;
        }

        public function listSettings()
        {
            $settings = $this->generalSettingRepository->all();
            //        dd($settings);
            return view('general_settings.index', compact('settings'));
        }

        public function createSetting()
        {
            return view('general_settings.create');
        }

        public function storeSetting($request)
        {
            $data = $request->all();

            try {
                $this->generalSettingRepository->create($data);
                return redirect()->route('general_settings.index')->with('message', "Item criado com sucesso.");
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: ' . $e->getMessage());
            }
        }

        public function showSetting($setting)
        {
            return view("general_settings.show", compact('setting'));
        }

        public function editSetting($setting)
        {
            $setting = $this->generalSettingRepository->find($setting->id);
            return view("general_settings.edit", compact('setting'));
        }

        public function updateSetting(Request $request, $setting)
        {
            $data = $request->all();

            //Salva os dados básicos no banco
            $data = array_filter($data, function ($value) {
                return ($value !== null);
            });

            try {
                $this->generalSettingRepository->update($data, $setting->id);
                return redirect()->route('general_setting.index')->with('message', 'Item atualizado com sucesso');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: ' . $e->getMessage());
            }
        }

        public function destroyEquipment($setting)
        {
            try {
                $this->generalSettingRepository->delete($setting->id);
                return redirect()->route('general_settings.index')->with('message', 'Item excluído com sucesso.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: ' . $e->getMessage());
            }
        }
    }
