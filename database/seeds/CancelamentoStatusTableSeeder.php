<?php

use Illuminate\Database\Seeder;

class CancelamentoStatusTableSeeder extends Seeder
{

    public function run()
    {
        // TestDummy::times(20)->create('App\Post');

        $listaCancelamentoStatus = [
            "Abandonado",
            "Acesso obstruído/inacessível",
            "Administrativo",
            "Anulada",
            "Aparelho fora de linha",
            "Área insegura",
            "Ausência de mão de obra",
            "Banheiro sem metragem mínima",
            "Cancelado",
            "Cancelado pela cobrança",
            "Cancelado pelo monitoramento",
            "Cliente aderiu ao plano",
            "Cliente ausente",
            "Cliente ausente c/ ou s/ comp",
            "Cliente ausente c/comprovação",
            "Cliente ausente s/comprovação",
            "Cliente cancelou o serviço",
            "Cliente comprou c/ terceiros",
            "Cliente desistiu",
            "Cliente não permitiu",
            "Cliente sem equipamento",
            "Cliente utilizando GLP",
            "Cliente/Porteiro não permitiu",
            "Condições adversas do tempo",
            "Endereço fechado/abandonado",
            "Endereço incorreto",
            "Endereço não localizado",
            "Equipe ECC sem material",
            "Existência de Exigências",
            "Fechado",
            "Fora do horário comercial",
            "Funcionário prédio não permite",
            "Interditado",
            "Local em obras",
            "Medidor inacessível",
            "Não cumprimento de prazo",
            "Obras",
            "PI não localizado",
            "PI trancado",
            "Realizado serv. c/ particular",
            "Reprog por falta técnico",
            "Reprog solicitada cliente",
            "Risco de segurança",
            "Sem gás na linha",
            "Sem medidor no local",
            "Sem necessidade do serviço",
            "Sem PI",
            "Sem responsável no local",
            "Serviço direcion p/ outra ECC",
            "Serviço incorreto",
            "Técnico atendido menor de idade",
            "Troca de titularidade",
            "Tubulação entupida",
            "Vazamento",
            "Visita horário noturno",
            "Vistoria com exigência",
        ];

        foreach ($listaCancelamentoStatus as $cancelamento) {
            DB::table('cancelamento_statuses')->insert([
                [
                    'name' => $cancelamento,
                ]
            ]);
        }
    }

}