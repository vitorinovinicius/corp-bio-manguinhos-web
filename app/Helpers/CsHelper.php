<?php

use App\Mail\SendMailTest;
use App\Models\ActivityLog;
use App\Models\Alert;
use Carbon\Carbon;

if (!function_exists('send_email')) {

    function send_email($viewName, $data, $subject = null)
    {
        $host = env('MAIL_HOST');
        $port = env('MAIL_PORT');
        $encryption = env('MAIL_ENCRYPTION');
        $username = env('MAIL_USERNAME');
        $password = env('MAIL_PASSWORD');

        $transport = new Swift_SmtpTransport($host, $port, $encryption);
        $transport->setUsername($username);
        $transport->setPassword($password);

        $new_mail = new Swift_Mailer($transport);

        Mail::setSwiftMailer($new_mail);

        if($data){
            $to = $data->email;
        }else{
            $to = "";
        }

        Mail::to($to)->send(new SendMailTest($viewName, $data, $subject));

    }
}

if (!function_exists('tipoAssinatura')) {
    function tipoAssinatura($type_id)
    {
        switch ($type_id) {
            case "1":
                $tipo = "Elaborado";
                break;

            case "2":
                $tipo = "Cliente";
                break;
            case "3":
                $tipo = "Síndico";
                break;
            default:
                $tipo = "-";
                break;
        }
        return $tipo;
    }
}
/**
 * Created by PhpStorm.
 * User: CELTAPHP
 * Date: 17/11/2016
 * Time: 17:44
 */

if (!function_exists('criteriaSearch')) {
    function criteriaSearch($model)
    {


        // Caso seja role regiao pegar apenas tecnicos das empreiteiras que atendem a regiao que posso ver..

        /*
        $regionsUser = \Auth::user()->regions->implode('id', ',');
        $regiaoRole = \Auth::user()->hasRole('regiao');
        if ($regiaoRole) {
            $model = $model->whereIn('occurrences.region_id', [$regionsUser]);
        }
        */

        $city = Request::get('city');
        $district = Request::get('district');
        $address = Request::get('address');
        $cpf_cnpj = Request::get('cpf_cnpj');
        $client_number = Request::get('client_number');
        $search = Request::get('search');
        $setor_id = Request::get('setor_id');
        //GASMIG
        $client_converted = Request::get('client_converted');
        $client_billed = Request::get('client_billed');


        if (
            (isset($city) && !empty($city)) OR
            (isset($district) && !empty($district)) OR
            (isset($cpf_cnpj) && !empty($cpf_cnpj)) OR
            (isset($setor_id) && !empty($setor_id) && is_numeric($setor_id)) OR
            (isset($address) && !empty($address)) OR
            (isset($client_number) && !empty($client_number)) OR
            (isset($search) && !empty($search)) OR
            (isset($client_converted) && !empty($client_converted)) OR
            (isset($client_billed) && !empty($client_billed)) OR
            (isset($setor_id) && !empty($setor_id) && is_numeric($setor_id))
        ) {
            $model = $model->join('occurrence_clients', 'occurrences.occurrence_client_id', '=', 'occurrence_clients.id');
        }


        $occurrence_type_id = Request::get('occurrence_type_id');
        if (isset($occurrence_type_id) && !empty($occurrence_type_id)) {
            $model->where('occurrences.occurrence_type_id', '=', $occurrence_type_id);
        }

        //TIRANDO PARA FINS DE TESTE
         $contractor_id = Request::get('contractor_id');
         if (isset($contractor_id) && !empty($contractor_id)) {
             if (\Auth::user()->contractor_id) {
                 $model->where('occurrences.contractor_id', \Auth::user()->contractor_id); //Para não aparecer nada
             } else {

                 $model->where('occurrences.contractor_id', '=', $contractor_id);
             }
         }

//        $numero_os = Request::get('numero_os');
//        if (isset($numero_os) && !empty($numero_os)) {
//            $model->where('occurrences.numero_os', '=', trim($numero_os));
//        }
        $numero_os = Request::get('numero_os');
        if (isset($numero_os) && !empty($numero_os)) {
            if (strstr($numero_os, ",")) {
//                $clientList = explode(",", str_replace(" ", "", trim($numero_os)));
                $clientList = preg_split("/(,| )/", trim($numero_os));
                $model->whereIn('occurrences.numero_os', $clientList);
            } else {
                $aListClient = [];

                $clientList = preg_split('/\s+/', $numero_os);

                foreach ($clientList as $client) {
                    $aListClient[] = trim($client);
                }
                $model->whereIn('occurrences.numero_os', $clientList);
            }
        }

        $id_local = Request::get('id_local');
        if (isset($id_local) && !empty($id_local) && is_numeric($id_local)) {
            $model->where('occurrences.id', '=', $id_local);
        }

        $client_number = Request::get('client_number');
        if (isset($client_number) && !empty($client_number)) {
            if (strstr($client_number, ",")) {
                $clientList = explode(",", str_replace(" ", "", trim($client_number)));
                $model->whereIn('occurrence_clients.client_number', $clientList);
            } else {
                $aListClient = [];

                $clientList = preg_split('/\s+/', $client_number);

                foreach ($clientList as $client) {
                    $aListClient[] = trim($client);
                }
                $model->whereIn('occurrence_clients.client_number', $clientList);
            }
        }

        $city = Request::get('city');
        if (isset($city) && !empty($city)) {
            $model->where('occurrence_clients.city', '=', $city);
        }

        $city = Request::get('city');
        if (isset($city) && !empty($city)) {
            $model->where('occurrence_clients.city', '=', $city);
        }

        $organizacao = Request::get('organizacao');
        if (isset($organizacao) && !empty($organizacao)) {
            $model->where('occurrences.organizacao_id', '=', "$organizacao");
        }

        $cpf_cnpj = Request::get('cpf_cnpj');
        if (isset($cpf_cnpj) && !empty($cpf_cnpj)) {
            $model->where('occurrence_clients.cpf_cnpj', '=', $cpf_cnpj);
        }

        $district = Request::get('district');
        if (isset($district) && !empty($district)) {
            $model->where('occurrence_clients.district', 'LIKE', $district . '%');
        }

        $address = Request::get('address');
        if (isset($address) && !empty($address)) {
            $model->where('occurrence_clients.address', 'LIKE', '%' . $address . '%');
        }

        $scheduled_date = Request::get('scheduled_date');
        if (isset($scheduled_date) && !empty($scheduled_date)) {
            $scheduled_date = format_range_to_database($scheduled_date);
            $model->whereBetween('occurrences.schedule_date', [$scheduled_date[0], $scheduled_date[1]]);
        }

        $date_finish = Request::get('date_finish');
        if (isset($date_finish) && !empty($date_finish)) {
            $date_finish = format_range_to_database($date_finish);
            $model->whereBetween('occurrences.check_out', [$date_finish[0], $date_finish[1]]);
        }

        $priority = Request::get('priority');
        if (isset($priority) && !empty($priority)) {
            $model->where('occurrences.priority', '=', $priority);
        }

        $status = Request::get('status');
        if (isset($status) && $status != "") {
            $model->where('occurrences.status', '=', $status);
        }

        $shift = Request::get('shift');
        if (isset($shift) && $shift != "") {
            $model->where('occurrences.shift', '=', $shift);
        }

        $operator_id = Request::get('operator_id');
        if (isset($operator_id) && !empty($operator_id)) {
            if ($operator_id == "x") {
                $model->where('occurrences.operator_id', '=', null);
            } else {
                $model->where('occurrences.operator_id', '=', $operator_id);
            }
        }

        $motive_id = Request::get('motivo_id');
        if (isset($motive_id) && !empty($motive_id)) {
            $model->where('occurrences.cancelamento_status_id', '=', $motive_id);
        }

        $approved_date = Request::get('approved_date');
        if (isset($approved_date) && !empty($approved_date)) {
            $approved_date = format_range_to_database($approved_date);
            $model->whereBetween('occurrences.approved_date', [$approved_date[0], $approved_date[1]]);
        }
    }
}

if (!function_exists('format_range_to_database')) {
    function format_range_to_database($date_range)
    {
        $date_range = explode(" - ", $date_range);
        $date_range[0] = \Carbon\Carbon::createFromFormat("d/m/Y H:i:s", $date_range[0] . " 00:00:00");
        $date_range[1] = \Carbon\Carbon::createFromFormat("d/m/Y H:i:s", $date_range[1] . " 23:59:59");
        return $date_range;
    }
}
if (!function_exists('osTotalType')) {
    function osTotalType($type, $mes, $ano, $tipo)
    {

        if ($tipo == "realized") {

            $value = DB::select("SELECT count(o.id) as qtd FROM occurrences o
                              WHERE
                              o.status = 2 AND
                              YEAR(o.schedule_date) = '$ano' AND
                              MONTH(o.schedule_date) = '$mes' AND
                              o.occurrence_type_id = $type"
            );
            $value = $value[0]->qtd;
            return $value;
        }
    }
}

if (!function_exists('convertDate')) {
    function convertDate($date)
    {
        $aData = explode("/", $date);
        return $aData[2] . "-" . $aData[1] . "-" . $aData[0];
    }
}

if (!function_exists('roleHasPermission')) {
    function roleHasPermission($role_id, $permission_id)
    {
        $rolePermission = DB::table("permission_role")
            ->select("value")
            ->where('role_id', $role_id)
            ->where('permission_id', $permission_id)
            ->first();
        if ($rolePermission)
            return $rolePermission->value;
        else
            return 2; //só para não dar problema com a comparação de zero
    }
}
if (!function_exists('myRegions')) {
    function myRegions()
    {
        return Auth::user()->regions->pluck('id')->toArray();
    }
}

if (!function_exists('myRegionsImplode')) {
    function myRegionsImplode()
    {
        return Auth::user()->regions->implode('id', ',');
    }
}

if (!function_exists('myContractorsId')) {
    function myContractorsId()
    {

        $contractors = DB::table("region_contractors")
            ->select("contractor_id")
            ->whereIn('region_id', myRegions())
            ->groupBy('contractor_id')
            ->get()
            ->pluck('contractor_id')
            ->toArray();

        return $contractors;
    }
}

if (!function_exists('myRegionsContractor')) {
    function myRegionsContractor()
    {

        $contractors = DB::table("region_contractors")
            ->select("contractor_id", "region_id")
            ->where('contractor_id', '=', Auth::user()->contractor_id);

        return $contractors;
    }
}
if (!function_exists('select_cancelamento_id')) {
    function select_cancelamento_id()
    {
        return array(
            "11" => "Cliente realizou IPG com outra IOA",
            "12" => "Preço da inspeção",
            "13" => "Divergencia entre a venda e a explicação do técnico",
            "14" => "Por motivo particular",
            "15" => "Mudança de endereço / Troca de Titularidade",
            "16" => "Não cumprimento de prazo",
            "17" => "Sindico proibiu a realização da IPG",
            "18" => "Cliente não deseja realizar no momento",
            "19" => "Apartamento sem equipamentos / Apartamento em Obra",
            "20" => "Conflito normativo",
            "21" => "Impasse entre Inquilino e proprietario do imovel",
            "22" => "Má execução da IPG - tecnico",
            "23" => "Clientes baixados, fechado por divida e escapamento",
            "24" => "Fazenda Botafogo",
            "25" => "Área Insegura",
            "26" => "Serviço incorreto",
            "27" => "Cliente impediu o termino da inspeção",
            "28" => "Inspeção com mais de 120 / 180 dias",
            "29" => "Reprogramado / Solicitado pelo cliente",
        );
    }
}
if (!function_exists('csvToArray')) {
    function csvToArray($filename = '', $delimiter = '\t')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $row = 0;

        $listaOs = [];

        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 5000, "\r")) !== FALSE) {
                $linha = utf8_encode(trim($data[0]));
                if ($linha) {
                    $listaOs[$row] = explode("\t", $linha);
                    $row++;
                }
            }
            fclose($handle);
        }

        $resultCsv = [];
        $listaOsComChave = [];
        $colunaSemNome = 0;
        $find_telefone = 0;
        $find_obs = 0;

        if (count($listaOs)) {
            for ($i = 1; $i <= count($listaOs); $i++) {
                $colunaNumber = 0;
                foreach ($listaOs[0] as $valueKeyColuna) {

                    $valueKeyColuna = str_replace(".", "", trim($valueKeyColuna));
                    $valueKeyColuna = str_replace("-", "", trim($valueKeyColuna));
                    $valueKeyColuna = str_replace("ÿþ", "", trim($valueKeyColuna));
                    $valueKeyColuna = str_replace("/", "", trim($valueKeyColuna));
                    $valueKeyColuna = str_replace(" ", "_", trim($valueKeyColuna));
                    $keyHeader = tirarAcentos($valueKeyColuna);
                    $keyHeader = str_replace("\x00", "", $keyHeader);
                    $keyHeader = ltrim($keyHeader);

                    if ($keyHeader == "") {
                        $colunaSemNome++;
                        $keyHeader = "coluna" . $colunaSemNome;
                    } else {
                        if ($keyHeader == "telefone") {
                            $find_telefone++;
                            $keyHeader = "telefone" . $find_telefone;
                        }
                        if ($keyHeader == "comentario") {
                            $find_obs++;
                            $keyHeader = "comentario" . $find_obs;
                        }
                    }

                    if (isset($listaOs[$i])) {
                        if (isset($listaOs[$i][$colunaNumber])) {
                            $textValue = str_replace("\"", "", $listaOs[$i][$colunaNumber]);
                            $textValue = str_replace("\x00", "", $textValue);
                            $resultCsv[$keyHeader] = $textValue;
                        }
                    }

                    $colunaNumber++;
                }

                $find_telefone = 0;
                $find_obs = 0;

                array_push($listaOsComChave, $resultCsv);
            }
        }

        return $listaOsComChave;
    }
}


if (!function_exists('configInfo')) {
    function configInfo($config_id)
    {

        $contractors = DB::table("configurations")
            ->select("*")
            ->where('config_key', '=', $config_id);

        return $contractors;
    }
}
if (!function_exists('retira_acentos')) {
    function retira_acentos($texto, $tamanho = "upper")
    {

        $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
        , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
        $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
        , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
        if ($tamanho == "upper") {
            return strtoupper(str_replace($array1, $array2, $texto));
        }
        if ($tamanho == "lower") {
            return strtolower(str_replace($array1, $array2, $texto));
        }
        if ($tamanho == "normal") {
            return str_replace($array1, $array2, $texto);
        }

    }
}
if (!function_exists('tirarAcentos')) {
    function tirarAcentos($string)
    {
        $string = trim($string);
        return strtolower(preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(Ç|ç)/", "/( |\/)/", "/\./", "/(-)/", "/(__)/", "/(º)/"), explode(" ", "a a e e i e o o u u n n c _  _ "), $string));
    }
}

if (!function_exists('retira_acentos_espacos')) {
    function retira_acentos_espacos($texto, $tamanho = "lower")
    {
        $array = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(Ç|ç)/", "/( |\/)/", "/\./", "/(-)/", "/(__)/", "/(º)/"), explode(" ", "a a e e i e o o u u n n c _  _ "), $texto);

        if ($tamanho == "upper") {
            return strtoupper($array);
        }
        if ($tamanho == "lower") {
            return strtolower($array);
        }

        return $array;
    }
}


if (!function_exists('priority_list')) {
    function priority_list_array()
    {
        return array(
            1 => "Baixa",
            2 => "Normal",
            3 => "Alta",
            4 => "Urgente",
            5 => "Especial",
            6 => "Judicial",
        );
    }
}

if (!function_exists('priority_color_id')) {
    function priority_color_id($key)
    {
        switch ($key) {
            case 4  :
                $class = "bg-red-active color-palette";
                break;
            case 5  :
                $class = "bg-red-active color-palette";
                break;
            case 6  :
                $class = "bg-red-active color-palette";
                break;
            default :
                $class = "";
                break;
        }
        return $class;
    }
}

if (!function_exists('priority_name')) {
    function priority_name($key)
    {
        switch ($key) {
            case 1  :
                $priority = "Baixa";
                break;
            case 2  :
                $priority = "Normal";
                break;
            case 3  :
                $priority = "Alta";
                break;
            case 4  :
                $priority = "Urgente";
                break;
            case 5  :
                $priority = "Especial";
                break;
            case 6  :
                $priority = "Judicial";
                break;
            default :
                $priority = "";
                break;
        }
        return $priority;
    }
}
if (!function_exists('priority_id')) {
    function priority_id($key)
    {
        switch ($key) {
            case "Baixa"    :
                $priority = 1;
                break;
            case "Normal"   :
                $priority = 2;
                break;
            case "Alta"     :
                $priority = 3;
                break;
            case "Urgente"  :
                $priority = 4;
                break;
            case "Especial" :
                $priority = 5;
                break;
            case "Judicial" :
                $priority = 6;
                break;
            default         :
                $priority = null;
                break;
        }
        return $priority;
    }
}
if (!function_exists('turno_id')) {
    function turno_id($key)
    {
        switch ($key) {
            case "Manhã"    :
                $turno = 1;
                break;
            case "Tarde"   :
                $turno = 2;
                break;
            case "Noite"     :
                $turno = 3;
                break;
            default         :
                $turno = null;
                break;
        }
        return $turno;
    }
}
if (!function_exists('uf_list')) {
    function uf_list()
    {
        return array(
            "AC" => "Acre",
            "AL" => "Alagoas",
            "AP" => "Amapá",
            "AM" => "Amazonas",
            "BA" => "Bahia",
            "CE" => "Ceará",
            "DF" => "Distrito Federal",
            "ES" => "Espírito Santo",
            "GO" => "Goiás",
            "MA" => "Maranhão",
            "MT" => "Mato Grosso",
            "MS" => "Mato Grosso do Sul",
            "MG" => "Minas Gerais",
            "PA" => "Pará",
            "PB" => "Paraíba",
            "PR" => "Paraná",
            "PE" => "Pernambuco",
            "PI" => "Piauí",
            "RJ" => "Rio de Janeiro",
            "RN" => "Rio Grande do Norte",
            "RS" => "Rio Grande do Sul",
            "RO" => "Rondônia",
            "RR" => "Roraima",
            "SC" => "Santa Catarina",
            "SP" => "São Paulo",
            "SE" => "Sergipe",
            "TO" => "Tocantins",
        );
    }
}

if (!function_exists('getToFU')) {
    function getToUf($uf)
    {
        switch ($uf) {

            case "AC":
                $nome_estado = "Acre";
                break;

            case "AL":
                $nome_estado = "Alagoas";
                break;

            case "AP":
                $nome_estado = "Amapá";
                break;

            case "AM":
                $nome_estado = "Amazonas";
                break;

            case "BA":
                $nome_estado = "Bahia";
                break;

            case "CE":
                $nome_estado = "Ceará";
                break;

            case "DF":
                $nome_estado = "Distrito Federal";
                break;

            case "GO":
                $nome_estado = "Goiás";
                break;

            case "RO":
                $nome_estado = "Rondônia";
                break;

            case "ES":
                $nome_estado = "Espírito Santo";
                break;

            case "MA":
                $nome_estado = "Maranhão";
                break;

            case "MT":
                $nome_estado = "Mato Grosso";
                break;

            case "MS":
                $nome_estado = "Mato Grosso do Sul";
                break;

            case "MG":
                $nome_estado = "Minas Gerais";
                break;

            case "PA":
                $nome_estado = "Pará";
                break;

            case "PB":
                $nome_estado = "Paraiba";
                break;

            case "PR":
                $nome_estado = "Paraná";
                break;

            case "PE":
                $nome_estado = "Pernambuco";
                break;

            case "PI":
                $nome_estado = "Piauí";
                break;

            case "RJ":
                $nome_estado = "Rio de Janeiro";
                break;

            case "RN":
                $nome_estado = "Rio Grande do Norte";
                break;

            case "RS":
                $nome_estado = "Rio Grande do Sul";
                break;

            case "RR":
                $nome_estado = "Roraima";
                break;

            case "SP":
                $nome_estado = "São Paulo";
                break;

            case "SC":
                $nome_estado = "Santa Catarina";
                break;

            case "SE":
                $nome_estado = "Sergipe";
                break;

            case "TO":
                $nome_estado = "Tocantins";
                break;

            default :
                $nome_estado = "-";
        }
        return $nome_estado;
    }
}


/**
 * HELPERS PARA OCORRÊNCIA TIPO 0725.01
 */

if (!function_exists('isNull')) {
    function isNull($value)
    {
        //1 - Sim / 0 - Não
        if (empty($value)) {
            return "-";
        } else {
            return $value;
        }
    }
}
if (!function_exists('sim_nao')) {
    function sim_nao($value)
    {
        //1 - Sim / 0 - Não
        switch ($value) {
            case "0":
                $tipo = "Não";
                break;

            case "1":
                $tipo = "Sim";
                break;

            case "2":
                $tipo = "Não";
                break;

            default:
                $tipo = "-";
                break;
        }
        return $tipo;
    }
}
if (!function_exists('status_schedule')) {
    function status_schedule($value)
    {
        //1 - Sim / 0 - Não
        switch ($value) {
            case "0":
                $tipo = "Não";
                break;

            case "1":
                $tipo = "Pendente";
                break;

            case "2":
                $tipo = "Sim";
                break;

            default:
                $tipo = "-";
                break;
        }
        return $tipo;
    }
}
if (!function_exists('totalOSRelatorio')) {

    function totalOsRelatorio($id, $contractor_name, $filter)
    {

        $schedules_realized = DB::select("SELECT COUNT(o.id) as qtd FROM occurrences o
                                                WHERE
                                                 o.status = 2
                                                AND o.contractor_id = $id
                                                $filter");


        $schedules_unsolved = DB::select("SELECT COUNT(o.id) as qtd FROM occurrences o
                                                WHERE o.status = 3
                                                AND o.contractor_id = $id
                                                $filter
                                        ");

        $schedules_realized = $schedules_realized[0]->qtd;
        $schedules_unsolved = $schedules_unsolved[0]->qtd;

        return "['$contractor_name', $schedules_realized, $schedules_unsolved],";
    }
}
if (!function_exists('getRengaeDate')) {
    //0 ou null - Sem pendencia / 1 - 60 dias / 2 - 90 dias / 3 - LACRE
    function occurrenceDateFilterSql($value)
    {

        if ($value) {
            $explodData = explode("-", $value);
            $explodDataIni = explode("/", trim($explodData[0]));
            $explodDataFim = explode("/", trim($explodData[1]));


            $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
            $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

            if ($dataIni != "" && $dataFim != "") {
                $sqlWhereContractor = " AND o.schedule_date BETWEEN '$dataIni' AND '$dataFim' ";
            } else {
                $sqlWhereContractor = " AND o.schedule_date = CURDATE()  ";
            }
        } else {
            $sqlWhereContractor = " AND o.schedule_date = CURDATE()  ";
        }

        return $sqlWhereContractor;

    }
}


if (!function_exists('motivoNaoRealizadoNew')) {
    function motivoNaoRealizadoNew($motivo_id)
    {

        $motivo = \App\Models\CancelamentoStatus::where("id", "=", $motivo_id)->first();

        if ($motivo) {
            return $motivo->name;
        } else {
            return "";
        }

    }
}

if (!function_exists('calcDiffMinute')) {
    function calcDiffMinute($dt1, $dt2)
    {

        $dtIni = Carbon::parse($dt1);
        $dtFim = Carbon::parse($dt2);

        return $dtIni->diffInMinutes($dtFim);
    }
}

if (!function_exists('tipoConexao')) {
    function tipoConexao($dt1, $dt2)
    {

        /*
         * +--------------+
            | tipo_conexao |
            +--------------+
            | NULL         |
            | wifi         |
            | 4g           |
            | 3g           |
            | none         |
            | unknown      |
            | 2g           |
            +--------------+
         */

        $dtIni = Carbon::parse($dt1);
        $dtFim = Carbon::parse($dt2);

        return $dtIni->diffInMinutes($dtFim);
    }
}


if (!function_exists('tempo_corrido')) {
    function tempo_corrido($time)
    {

        $now = strtotime(date('m/d/Y H:i:s'));
        $time = strtotime($time);
        $diff = $now - $time;

        $seconds = $diff;
        $minutes = round($diff / 60);
        $hours = round($diff / 3600);
        $days = round($diff / 86400);
        $weeks = round($diff / 604800);
        $months = round($diff / 2419200);
        $years = round($diff / 29030400);

        if ($seconds <= 60) return "1 min atrás";
        else if ($minutes <= 60) return $minutes == 1 ? '1 min atrás' : $minutes . ' min atrás';
        else if ($hours <= 24) return $hours == 1 ? '1 hrs atrás' : $hours . ' hrs atrás';
        else if ($days <= 7) return $days == 1 ? '1 dia atras' : $days . ' dias atrás';
        else if ($weeks <= 4) return $weeks == 1 ? '1 semana atrás' : $weeks . ' semanas atrás';
        else if ($months <= 12) return $months == 1 ? '1 mês atrás' : $months . ' meses atrás';
        else return $years == 1 ? 'um ano atrás' : $years . ' anos atrás';
    }
}

if (!function_exists('tempo_calc')) {
    function tempo_calc($time)
    {

        if (empty($time)) {
            return false;
        }

        $time = strtotime($time);
        return $time;
    }
}
if (!function_exists('tempo_color')) {
    function tempo_color($time)
    {

        $now = strtotime(date('m/d/Y H:i:s'));
        $time = strtotime($time);
        $diff = $now - $time;

        $seconds = $diff;
        $minutes = round($diff / 60);
        $hours = round($diff / 3600);
        $days = round($diff / 86400);
        $weeks = round($diff / 604800);
        $months = round($diff / 2419200);
        $years = round($diff / 29030400);

        if ($seconds <= 60) return "success";
        else if ($minutes <= 60) return 'success';
        else if ($hours <= 3) return 'warning';
        else if ($hours <= 5) return 'warning';
        else if ($days <= 7) return 'danger';
        else if ($weeks <= 4) return 'danger';
        else if ($months <= 12) return 'danger';
        else return 'danger';
    }
}
if (!function_exists('bateria_color')) {
    function bateria_color($battery)
    {

        $int = (int)filter_var($battery, FILTER_SANITIZE_NUMBER_INT);

        if ($int >= 80) return "success";
        else if ($int >= 60) return 'warning';
        else if ($int >= 40) return 'warning';
        else if ($int < 40) return 'danger';
        else return 'danger';
    }
}
if (!function_exists('tecnical_color')) {
    function tecnical_color($porcentagem)
    {

        if ($porcentagem >= 85.0) return "success tecnical";
        else if ($porcentagem < 85.0 && $porcentagem >= 50.0) return 'warning tecnical';
        else if ($porcentagem < 50.0 && $porcentagem >= 0.0) return 'danger tecnical';
        else return '';
    }
}
if (!function_exists('teams_os_realizadas')) {
    function teams_os_realizadas($team_id, $dt_inicial, $dt_final)
    {
        $dt_inicial = str_replace('/', '-', $dt_inicial);
        $dt_final = str_replace('/', '-', $dt_final);

        $value = DB::select("SELECT o.id, o.schedule_date
            FROM occurrences o, user_team ut
            WHERE
            o.operator_id = ut.user_id
            AND
            ut.team_id = $team_id
            AND
            (o.schedule_date BETWEEN '" . date("Y-m-d", strtotime($dt_inicial)) . "' AND '" . date("Y-m-d", strtotime($dt_final)) . "')");
        return count($value);
    }
}


if (!function_exists('team_days_range')) {
    function team_days_range($dt_inicial, $dt_final)
    {
        //exemplo
        // Calcula a diferença em segundos entre as datas
        $diferenca = strtotime(str_replace('/', '-', $dt_final)) - strtotime(str_replace('/', '-', $dt_inicial));
        //Calcula a diferença em dias
        $dias = floor($diferenca / (60 * 60 * 24));
        return $dias;
    }
}

if (!function_exists('null_or_na')) {
    function null_or_na($value)
    {

        if ($value == "" || empty($value) || $value == null) {
            return "-";
        } else {
            return $value;
        }
    }
}

if (!function_exists('Mask')) {
    function Mask($mask, $str)
    {

        $str = str_replace(" ", "", $str);

        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }

        return $mask;
    }
}

if (!function_exists('select_form_type')) {
    function select_form_type()
    {
        return array(
            "1" => "Dinâmico",
            "2" => "Estático",
            "3" => "Misto",
        );
    }
}
if (!function_exists('value_form_type')) {
    function value_form_type($value)
    {
        //1 - Sim / 0 - Não
        switch ($value) {
            case "1":
                $tipo = "Dinâmico";
                break;

            case "2":
                $tipo = "Estático";
                break;

            case "3":
                $tipo = "Misto";
                break;

            default:
                $tipo = "-";
                break;
        }
        return $tipo;
    }
}
if (!function_exists('ativo_inativo')) {
    function ativo_inativo($value)
    {
        //1 - Sim / 0 - Não
        switch ($value) {
            case "0":
                $tipo = "Inativo";
                break;

            case "1":
                $tipo = "Ativo";
                break;

            case "2":
                $tipo = "Inativo";
                break;

            default:
                $tipo = "-";
                break;
        }
        return $tipo;
    }
}

if (!function_exists('calcula_minutos')) {
    function calcula_minutos($dataInicial, $dataFinal)
    {
        $date_time = new DateTime($dataInicial);
        $diff = $date_time->diff(new DateTime($dataFinal));
        return $diff->format('%h:%I:%S');
    }
}

/** INICIO DE HELPERS IN */
if (!function_exists('tipo_de_abastecimento')) {
    function tipo_de_abastecimento($value)
    {
        //1 - Gás Natural / 2 - GLP / 3 - MPA / 4 - BP / 5 - MPB
        switch ($value) {
            case "1":
                $tipo = "Gás Natural";
                break;

            case "2":
                $tipo = "GLP";
                break;

            case "3":
                $tipo = "MPA";
                break;

            case "4":
                $tipo = "BP";
                break;

            case "5":
                $tipo = "MPB";
                break;

            default:
                $tipo = "Não informado";
                break;
        }
        return $tipo;
    }
}
if (!function_exists('pressao')) {
    function pressao($value)
    {
        //1 - MP / 2 - BP
        switch ($value) {
            case "1":
                $tipo = "MP";
                break;

            case "2":
                $tipo = "BP";
                break;

            default:
                $tipo = "Não informado";
                break;
        }
        return $tipo;
    }
}

if (!function_exists('laudo')) {
    function laudo($value)
    {
        //1 - Não foram detectados defeitos principais ou secundários / 2 - Existem defeitos principais / 3 - Existem defeitos secundários
        switch ($value) {
            case "1":
                $tipo = "NÃO FORAM DETECTADOS DEFEITOS";
                break;

            case "2":
                $tipo = "EXISTEM DEFEITOS";
                break;

            default:
                $tipo = "Não informado";
                break;
        }
        return $tipo;
    }
}

if (!function_exists('in_situacao')) {
    function in_situacao($value)
    {
        switch ($value) {
            case "1":
                $tipo = "C";
                break;

            case "2":
                $tipo = "NC";
                break;

            case "3":
                $tipo = "N/A";
                break;

            case "4":
                $tipo = "RL";
                break;

            default:
                $tipo = "C";
                break;
        }
        return $tipo;
    }
}

if (!function_exists('in_color_label')) {
    function in_color_label($value)
    {
        //exemplo
        switch ($value) {

            case "0":
                $tipo = "label-danger";
                break;

            case "1":
                $tipo = "label-success";
                break;

            case "2":
                $tipo = "label-danger";
                break;

            case "3":
                $tipo = "label-primary";
                break;

            case "4":
                $tipo = "label-default";
                break;

            default:
                $tipo = "label-success";
                break;
        }
        return $tipo;
    }
}

if (!function_exists('raminicacao_interna')) {
    function raminicacao_interna($value)
    {
        //1 - Aparente 2 - Polietileno 3 - Enterrado
        switch ($value) {
            case "1":
                $tipo = "Aparente";
                break;

            case "2":
                $tipo = "Embutido";
                break;

            case "3":
                $tipo = "Enterrado";
                break;

            default:
                $tipo = "-";
                break;
        }
        return $tipo;
    }
}

if (!function_exists('ri_material')) {
    function ri_material($value)
    {
        //1 - Cobre / 2 - Ferro Galvanizado / 3 - Outro
        switch ($value) {
            case "1":
                $tipo = "Cobre";
                break;

            case "2":
                $tipo = "Polietileno";
                break;

            case "3":
                $tipo = "Aço";
                break;

            case "4":
                $tipo = "PE";
                break;

            case "5":
                $tipo = "PEX";
                break;

            default:
                $tipo = "-";
                break;
        }
        return $tipo;
    }
}

if (!function_exists('combustao')) {
    function combustao($value)
    {
        //1 - Aberta / 2 - Fechada
        switch ($value) {
            case "1":
                $tipo = "Aberta";
                break;

            case "2":
                $tipo = "Fechada";
                break;

            default:
                $tipo = "Não informado";
                break;
        }
        return $tipo;
    }
}

if (!function_exists('tiragem')) {
    function tiragem($value)
    {
        //1 - Natural / 2 - Forçada
        switch ($value) {
            case "1":
                $tipo = "Natural";
                break;

            case "2":
                $tipo = "Forçada";
                break;

            default:
                $tipo = "Não informado";
                break;
        }
        return $tipo;
    }
}

if (!function_exists('funcionamento')) {
    function funcionamento($value)
    {
        //1 - Bom / 2 - Ruim / 3 - Fora de uso
        switch ($value) {
            case "1":
                $tipo = "Bom";
                break;

            case "2":
                $tipo = "Ruim";
                break;

            case "3":
                $tipo = "Fora de uso";
                break;

            default:
                $tipo = "Não informado";
                break;
        }
        return $tipo;
    }
}

/** Fim DE HELPERS IN */

if (!function_exists('get_contractor')) {
    function get_contractor()
    {
        if (Auth::user()->contractor_id) {
            return Auth::user()->contractor_id;
        } else {
            return null;
        }
    }
}
/**
 * Return contractor_id
 */
if (!function_exists('get_contractor_to_s3')) {
    function get_contractor_to_s3()
    {
        if (Auth::user()->contractor_id) {
            return Auth::user()->contractor_id . "/";
        } else {
            return null;
        }
    }
}

/***HELPERS DO DASHBOARD AJAX****/
if (!function_exists('dashboard_count_total_os')) {
    function dashboard_count_total_os($operator_id)
    {
        //exemplo
        $value = DB::select("SELECT id FROM occurrences
                              WHERE schedule_date = CURDATE()
                              AND operator_id = $operator_id");
        return count($value);
    }
}

if (!function_exists('dashboard_os_realizadas')) {
    function dashboard_os_realizadas($operator_id)
    {
        //exemplo
        $value = DB::select("SELECT id FROM occurrences
                              WHERE schedule_date = CURDATE()
                              AND operator_id = $operator_id
                              AND open_close <> 1
                              AND realized = 1");
        return count($value);
    }
}
if (!function_exists('dashboard_os_pendent')) {
    function dashboard_os_pendent($operator_id)
    {
        //exemplo
        $value = DB::select("SELECT id FROM occurrences
                              WHERE schedule_date = CURDATE()
                              AND operator_id = $operator_id
                              AND open_close = 1
                              AND realized <> 1");
        return count($value);
    }
}
if (!function_exists('dashboard_os_reagendadas')) {
    function dashboard_os_reagendadas($operator_id)
    {
        //exemplo
        $value = DB::select("SELECT id FROM occurrences
                              WHERE schedule_date = CURDATE()
                              AND operator_id = $operator_id
                              AND realized <> 1
                              AND realocar = 1");
        return count($value);
    }
}
if (!function_exists('dashboard_unsolved')) {
    function dashboard_unsolved($operator_id)
    {
        //exemplo
        $value = DB::select("SELECT id FROM occurrences
                            WHERE schedule_date = CURDATE()
                            AND open_close <> 1
                            AND realized <> 1
                            AND check_out IS NOT NULL
                            AND operator_id = $operator_id ");
        return count($value);
    }
}

if (!function_exists('dashboard_operator')) {
    function dashboard_operator($operator)
    {

        $scheduled_date = Request::input('scheduled_date');
        if ($scheduled_date) {
            $explodData = explode("-", $scheduled_date);
            $explodDataIni = explode("/", trim($explodData[0]));
            $explodDataFim = explode("/", trim($explodData[1]));

            $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0] . " 00:00:00";
            $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0] . " 23:59:59";
        } else {
            $dataIni = null;
            $dataFim = null;
        }

        $return = array();

        if($scheduled_date && $dataIni != null && $dataFim != null){

            $return["total_os"] = $operator->occurrences()->whereBetween('schedule_date', [$dataIni,$dataFim])->count();
            $return["total_pendente"] = $operator->occurrences()->whereBetween('schedule_date', [$dataIni,$dataFim])->where('occurrences.status', 1)->count();
            $return["total_realizadas"] = $operator->occurrences()->whereBetween('schedule_date', [$dataIni,$dataFim])->where('occurrences.status', 2)->count();
            $return["total_nao_realizadas"] = $operator->occurrences()->whereBetween('schedule_date', [$dataIni,$dataFim])->where('occurrences.status', 3)->count();

            $return["total_os_atraso"] = $operator->alerts()->where('type',1)->whereBetween('created_at', [$dataIni,$dataFim])->count();
            $return["total_os_interferencia"] = $operator->alerts()->where('type',2)->whereBetween('created_at', [$dataIni,$dataFim])->count();
            $return["total_os_equipamento"] = $operator->alerts()->where('type',3)->whereBetween('created_at', [$dataIni,$dataFim])->count();
            $return["total_os_tempo_medio"] = $operator->alerts()->where('type',4)->whereBetween('created_at', [$dataIni,$dataFim])->count();
            $return["total_horas_extas"] = $operator->alerts()->where('type',5)->whereBetween('created_at', [$dataIni,$dataFim])->count();

        } else {
            $return["total_os"] = $operator->occurrences()->whereDate('schedule_date', date("Y-m-d"))->count();
            $return["total_pendente"] = $operator->occurrences()->whereDate('schedule_date', date("Y-m-d"))->where('occurrences.status', 1)->count();
            $return["total_realizadas"] = $operator->occurrences()->whereDate('schedule_date', date("Y-m-d"))->where('occurrences.status', 2)->count();
            $return["total_nao_realizadas"] = $operator->occurrences()->whereDate('schedule_date', date("Y-m-d"))->where('occurrences.status', 3)->count();
            $return["total_os_atraso"] = $operator->alerts()->where('type',1)->whereDate('created_at', date("Y-m-d"))->count();
            $return["total_os_interferencia"] = $operator->alerts()->where('type',2)->whereDate('created_at', date("Y-m-d"))->count();
            $return["total_os_equipamento"] = $operator->alerts()->where('type',3)->whereDate('created_at', date("Y-m-d"))->count();
            $return["total_os_tempo_medio"] = $operator->alerts()->where('type',4)->whereDate('created_at', date("Y-m-d"))->count();
            $return["total_horas_extas"] = $operator->alerts()->where('type',5)->whereDate('created_at', date("Y-m-d"))->count();

        }

        if ($return["total_os"] > 0) {

            $return["tecnical_color"] = number_format((float)($return["total_realizadas"] / (float)$return["total_os"]) * 100, 2, '.', '');

            $return["media"] = number_format(((float)($return["total_realizadas"] + (float)$return["total_nao_realizadas"]) / (float)$return["total_os"]) * 100, 2, '.', '');

            $return["eficiencia"] = number_format((float)($return["total_realizadas"] / (float)$return["total_os"]) * 100, 2, '.', '');

        } else {
            $return["tecnical_color"] = 0;
            $return["media"] = 0;
            $return["eficiencia"] = 0;
        }

        return $return;
    }
}

/***HELPERS DO DASHBOARD AJAX - FIM****/

if (!function_exists('bg_color')) {
    function bg_color($value)
    {
        //exemplo
        switch ($value) {

            case "1":
                $tipo = "bg-olive";
                break;

            case "2":
                $tipo = "bg-yellow";
                break;

            case "3":
                $tipo = "bg-maroon";
                break;

            case "4":
                $tipo = "bg-green";
                break;

            case "5":
                $tipo = "bg-teal";
                break;

            case "6":
                $tipo = "bg-orange";
                break;

            case "7":
                $tipo = "bg-red";
                break;

            case "8":
                $tipo = "bg-olive";
                break;

            case "9":
                $tipo = "bg-primary";
                break;

            case "10":
                $tipo = "bg-yellow";
                break;

            case "11":
                $tipo = "bg-maroon";
                break;

            case "12":
                $tipo = "bg-green";
                break;

            case "13":
                $tipo = "bg-teal";
                break;

            case "14":
                $tipo = "bg-orange";
                break;

            default:
                $tipo = "bg-primary";
                break;
        }
        return $tipo;
    }
}

if (!function_exists('gera_log')) {
    function gera_log($pathLog, $nameLog, $data)
    {

        file_put_contents(storage_path() . "/" . $pathLog . "/" . $nameLog, json_encode($data) . "\n", FILE_APPEND);

    }
}

if (!function_exists('FinancialstatusList')) {

    function FinancialstatusList()
    {
        return [
            "0" => "Pendente",
            "1" => "Aprovado",
            "2" => "Reprovado",
            "3" => "Solicitado ajuste",
            "4" => "Ajuste feito pela ECC",
        ];
    }
}

if (!function_exists('financialCommunicationstatusList')) {

    function financialCommunicationstatusList()
    {
        return [
            "0" => "Pendente",
            "1" => "Resolvido",
//            "2" => "Sendo avaliado",
        ];
    }
}
if (!function_exists('formata_scheduled_date')) {

    function formata_scheduled_date($scheduled_date)
    {
        $explodData = explode("-", $scheduled_date);
        $explodDataIni = explode("/", trim($explodData[0]));
        $explodDataFim = explode("/", trim($explodData[1]));

        $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
        $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

        if ($dataIni != "" && $dataFim != "") {
            return [$dataIni, $dataFim];
        } else {
            return [Carbon::now()->subDays(30)->format("Y-m-d"), Carbon::now()->format("Y-m-d")];
        }
    }
}

if (!function_exists('tipoAssinatura')) {
    function tipoAssinatura($type_id)
    {
        switch ($type_id) {
            case "1":
                $tipo = "Elaborado";
                break;

            case "2":
                $tipo = "Cliente";
                break;
            case "3":
                $tipo = "Síndico";
                break;
            default:
                $tipo = "-";
                break;
        }
        return $tipo;
    }
}

if (!function_exists('tipoVeiculo')) {
    function tipoVeiculo($type_id)
    {
        switch ($type_id) {
            case "1":
                $tipo = "Carro";
                break;

            case "2":
                $tipo = "Moto";
                break;
            default:
                $tipo = "-";
                break;
        }
        return $tipo;
    }
}
if (!function_exists('typeVehicle')) {

    function typeVehicle()
    {
        return [
            "1" => "Carro",
            "2" => "Moto",
        ];
    }
}


if (!function_exists('tipoChecklistVehicles')) {
    function tipoChecklistVehicles()
    {
        return [
            1 => "Carro",
            2 => "Moto",
            3 => "Ambos"
        ];

    }
}

if (!function_exists('tipoGas')) {
    function tipoGas($type_id)
    {
        switch ($type_id) {
            case "1":
                $tipo = "GN";
                break;

            case "2":
                $tipo = "GLP";
                break;
            default:
                $tipo = "";
                break;
        }
        return $tipo;
    }
}
if (!function_exists('pressaoRamal')) {
    function pressaoRamal($type_id)
    {
        switch ($type_id) {
            case "1":
                $tipo = "MPA";
                break;

            case "2":
                $tipo = "BP";
                break;
            default:
                $tipo = "";
                break;
        }
        return $tipo;
    }
}
if (!function_exists('status_work_day')) {
    function status_work_day($type_id)
    {
        switch ($type_id) {
            case "1":
                $tipo = "Botão";
                break;
            case "2":
                $tipo = "Robô";
                break;
            default:
                $tipo = "-";
                break;
        }
        return $tipo;
    }
}

if (!function_exists('tmpDeslocamento')) {
    function tmpDeslocamento($occurrence, $in, $out)
    {
        $values = DB::select("SELECT move_type_id, check_in FROM moves
                         WHERE
                         moves.occurrence_id = $occurrence->id  AND
                         moves.move_type_id IN ($in, $out)
                         ORDER BY move_type_id DESC "
        );
        $datainicio = null;
        $dataFinal = null;
        $tmp = "Não capturado";

        foreach ($values as $value) {
            if ($value->move_type_id == 5 || $value->move_type_id == 6) {
                $dataFinal = $value->check_in;
            } else {
                $datainicio = $value->check_in;
            }
        }
        if(isset($datainicio) && isset($dataFinal)){
            $tmp = calcula_minutos($datainicio, $dataFinal);
        }
        return $tmp;

    }
}

if (!function_exists('saveVersionForm')) {
    function saveVersionForm($formAtual)
    {
        $form_id = $formAtual->id;
        $version_number = $formAtual->version;

        $form = \App\Models\Form::with([
            'form_sections',
             'form_sections.form_fields'
        ])->find($form_id);

        $dataJson = [
            'form_id' => $formAtual->id,
            'json' => json_encode($form),
            'version' => $version_number,
        ];

        $formAtual->form_versions()->create($dataJson);
    }
}

if (!function_exists('erroMessageCreateNotContract')) {
    function erroMessageCreateNotContract()
    {
        return redirect()->back()->withInput()->with('error', 'Você não tem permissão de empresa para efetuar o registro.');
    }
}

if (!function_exists('logJson')) {
    function logJson($json)
    {
        if ($json != "") {
            $json = json_decode($json, true);

            $newArray = [];

            if ($json != null) {
                foreach ($json as $key => $item) {
                    if ($key == "type") {
                        $newArray['type'] = $item;
                    }
                    if ($key == "para") {
                        if (is_array($item) && count($item)) {
                            foreach ($item as $keyIn => $itenIn) {
                                $newArray['para'][$keyIn] = (is_array($itenIn)) ? (isset($itenIn['date'])) ? $itenIn['date'] : "" : $itenIn;
                            }
                        }
                    }
                    if ($key == "de") {
                        if (is_array($item) && count($item)) {
                            foreach ($item as $keyIn => $itenIn) {
                                $newArray['de'][$keyIn] = (is_array($itenIn)) ? (isset($itenIn['date'])) ? $itenIn['date'] : "" : $itenIn;
                            }
                        } else {
                            $newArray['de'] = [];
                        }
                    }
                }
            }

            return $newArray;
        }

        return false;
    }
}

// Function to get the user IP address
if (!function_exists('getUserIP')) {
    function getUserIP()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}

if (!function_exists('colorEventCalendar')) {
    function colorEventCalendar($status)
    {
        switch($status) {
            case "1":
                return "#5A8DEE";
            case "2":
                return "#39DA8A";
            case "3":
                return "#FF5B5C";
            case "4":
                return "#8a99b5";
            case "5":
                return "#FDAC41";
            case "6":
                return "#000000";

            default: return "#5A8DEE";
        }
    }
}

    if (!function_exists('occurrenceStatusBgColor')) {
        function occurrenceStatusBgColor($status)
        {
            switch($status) {
                case "2":
                    return "bg-success";
                case "3":
                    return "bg-danger";
                case "4":
                    return "bg-warning";
                case "5":
                    return "bg-info";

                default: return "bg-primary";
            }
        }
    }

if (!function_exists('string50PorCento')) {
    function string50PorCento($string)
    {
        $metade = strlen($string)/ 2;

        // Limitando string
        $corteTexto= substr($string, 0, $metade) . '...';

        return $corteTexto;
    }
}

if (! function_exists('getCoordsAddressGMAPS')) {
    function getCoordsAddressGMAPS($address = '')
    {
        /**
         *  Retorna as coordenadas geograficas do endereco informado
         */
        if (empty($address))
            return null;

        $googleMaps_Key = env('GOOGLE_MAPS_KEY');
        // $url = 'https://maps.google.com/maps/api/geocode/json?address='.utf8_decode(tirarAcentos(trim($address))).'&sensor=false'."&key=".$googleMaps_Key;

//        $address = mb_convert_encoding(tirarAcentos(trim($address)), 'UTF-8');
        $address = urlencode($address);
        $url = 'https://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false'."&key=".$googleMaps_Key;

        $client = new GuzzleHttp\Client();
        $response = $client->request('POST', $url);

        if($response->getStatusCode() === 200) { // success
            $content = $response->getBody();
            $jsonRes = json_decode($content->getContents(), true); // json com resposta do servidor

            if ($jsonRes['status'] != "OK")
                return null;

            $coords['lat'] = $jsonRes['results'][0]['geometry']['location']['lat'];
            $coords['lng'] = $jsonRes['results'][0]['geometry']['location']['lng'];

            return $coords;
        }
        return null;
    }
}

/** Calcula rotas com TomTom Directions API **/
if (! function_exists('calculateDirectionsTomTom'))
{
    function calculateDirectionsTomTom($waypoints)
    {
        $apiKey = 'axALzt2AlUYA0sR9KwERYXjZX3Q8jWKa';

        $url = 'https://api.tomtom.com/routing/1/calculateRoute/'.$waypoints.'/json?key='.$apiKey.'&computeBestOrder=true&routeType=shortest&travelMode=car';

        Log::error("URL GOOGLE >>> ".$url);

        $client = new GuzzleHttp\Client();
        $response = $client->request('GET', $url,[
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept-Encoding' => 'application/gzip'
            ]
        ]);

        $jsonRes = null;

        // success
        if($response->getStatusCode() === 200)
        {
            $content = $response->getBody();
            $jsonRes = json_decode($content->getContents(), true); // json com resposta do servidor
        }

//        Log::error("URL GOOGLE RESPONSE >>> ".json_encode($jsonRes));
        return $jsonRes;
    }
}

if (!function_exists('dataTimeFormat')) {
    function dataTimeFormat($dateTime)
    {
        return Carbon::parse($dateTime)->format('d/m/Y H:i:s');
    }
}

if(!function_exists('weekDay')) {
    function weekDay($value)
    {
        //exemplo
        switch ($value) {

            case "1":
                $day = "Domingo";
                break;

            case "2":
                $day = "Segunda-feira";
                break;

            case "3":
                $day = "Terça-feira";
                break;

            case "4":
                $day = "Quarta-feira";
                break;

            case "5":
                $day = "Quinta-feira";
                break;

            case "6":
                $day = "Sexta-feira";
                break;

            case "7":
                $day = "Sábado";
                break;
        }
        return $day;
    }
}

if(!function_exists('statusPayment')) {
    function statusPayment($value)
    {
        switch ($value) {

            case "1":
                return "Pendente";
                break;
            case "2":
                return "Pago";
                break;
            case "3":
                return "Recusado";
                break;
            default:
                return "Inválida";
        }
    }
}

    if (! function_exists('geraActivityLog')){
        function geraActivityLog($logName = null, $description = null, $properties = null, $subject_id = null, $subject_type = null, $causer_type = null)
        {

            ActivityLog::create([
                "log_name" => $logName,
                "description" => $description,
                "subject_id"=>$subject_id,
                "subject_type"=>$subject_type,
                "causer_id"=> Auth::user() ? Auth::user()->id : null,
                "causer_type"=>$causer_type,
                "properties"=>$properties,
            ]);
        }
    }


    if(! function_exists('base64ToImage')){
        function base64ToImage($base64_string, $output_file)
        {
            $file = fopen($output_file, "wb");

            fwrite($file, base64_decode($base64_string));

            fclose($file);

            return $output_file;
        }
    }

    if (!function_exists('occurrence_shift')) {
        function occurrence_shift($shift)
        {
            switch ($shift) {
                case 1  :
                    $shift = "Manhã";
                    break;
                case 2  :
                    $shift = "Tarde";
                    break;
                case 3  :
                    $shift = "Noite";
                    break;
                default :
                    $shift = "-";
                    break;
            }
            return $shift;
        }
    }
    if(!function_exists('dataAgendamentoFormartJS')){
        function dataAgendamentoFormartJS($schedule_date, $schedule_time, $shift){
            if($schedule_time){
                $shift = $schedule_time;
            } elseif ($shift == 1) { //Manhã
                $shift = " 08:00:00";
            } elseif ($shift == 2) { //tarde
                $shift = " 12:00:00";
            } elseif ($shift == 3) { //noite
                $shift = " 18:00:00";
            } else {
                $shift = " 00:00:00";
            }
            return Carbon::parse($schedule_date . " " . $shift)->format("H:i");
        }
    }


    if (!function_exists('bagde_color')) {
        function bagde_color($value)
        {
            //exemplo
            switch ($value) {

                case "0":
                    $tipo = "badge-danger";
                    break;
                case "1":
                    $tipo = "badge-primary";
                    break;

                case "2":
                    $tipo = "badge-warning";
                    break;

                case "3":
                    $tipo = "badge-sucess";
                    break;

                case "4":
                    $tipo = "badge-info";
                    break;

                default:
                    $tipo = "";
                    break;
            }
            return $tipo;
        }
    }

    if(!function_exists('dataAgendamentoFormartJSLimite')){
        function dataAgendamentoFormartJSLimite($average_time, $schedule_time, $schedule_date, $shift){
            if ($average_time && $schedule_time) {
                $schedule_time = Carbon::createFromFormat("H:i:s", $schedule_time);

                $time = explode(":", $average_time);
                $hour = $time[0];
                $minute = $time[1];

                $date_final = $schedule_time->addHours($hour)->addMinutes($minute)->format("H:i:s");

                return Carbon::parse($schedule_date . " " . $date_final)->format("H:i");
            } elseif (!$average_time && $schedule_time) {
                return Carbon::parse($schedule_date . " " . $schedule_time)->addHour()->format("H:i");
            } else {

                if ($shift == 1) { //Manhã
                    $shift = " 08:00:00";
                } elseif ($shift == 2) { //tarde
                    $shift = " 12:00:00";
                } elseif ($shift == 3) { //noite
                    $shift = " 18:00:00";
                } else {
                    $shift = " 00:00:00";
                }

                return Carbon::parse($schedule_date . " " . $shift)->addHour()->format("H:i");
            }
        }
    }
