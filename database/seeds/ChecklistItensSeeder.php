<?php

use Illuminate\Database\Seeder;

class ChecklistItensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('checklist_vehicle_itens')->insert(
            [
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'descricao' => 'A documentação da motocicleta está disponível e atualizada ? (Considere: Certificado de registro e licenciamento (CRLV), IPVA e seguro obrigatório).',
                    'type_id' => 2,//1=Carro 2 Moto
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'descricao' => 'O capacete está em condições adequadas de uso? (Sem avarias)',
                    'type_id' => 2,//1=Carro 2 Moto
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],[
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'descricao' => 'O condutor dispõe  de calçado de segurança em condições adequadas de uso? (Sem avarias)',
                    'type_id' => 2,//1=Carro 2 Moto
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],[
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'descricao' => 'O condutor dispõe  de colete Air Bag ? O colete está em condições adequadas de uso? (Sem avarias)',
                    'type_id' => 2,//1=Carro 2 Moto
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],[
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'descricao' => 'A motocicleta possui dispositivo de "Corta Linha"?',
                    'type_id' => 2,//1=Carro 2 Moto
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],[
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'descricao' => 'Os espelhos retrovisores estão em condições adequadas de uso? (Sem avarias)',
                    'type_id' => 2,//1=Carro 2 Moto
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],[
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'descricao' => 'As lanternas / faróis estão em condições adequadas de funcionamento? (Considere: Setas de sinalização, luz baixa / alta, luz de freio)',
                    'type_id' => 2,//1=Carro 2 Moto
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],[
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'descricao' => 'O condutor participou de treinamento de Direção defensiva?',
                    'type_id' => 2,//1=Carro 2 Moto
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],[
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'descricao' => 'O estado geral de conservação (aparência) da motocicleta é adequado?(Considere: limpeza e avarias).',
                    'type_id' => 2,//1=Carro 2 Moto
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],[
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'descricao' => 'A motocicleta possui dispositivo "Mata Cachorro"?',
                    'type_id' => 2,//1=Carro 2 Moto
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],[
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'descricao' => 'As rodas e os pneus estão em condições adequadas de uso? (Considere: Avarias, desgaste e deformações).',
                    'type_id' => 2,//1=Carro 2 Moto
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
            ]
        );
    }
}
