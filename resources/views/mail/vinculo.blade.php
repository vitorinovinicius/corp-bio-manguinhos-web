<div style="font-family: 'Open Sans', sans-serif; font-size: 14px; line-height: 1.5; color: #333; margin-top: 50px; font-weight: normal;">
    <div style="padding: 50px 50px 30px 50px;">
        <div style="padding-top: 70px;">
            <p>Olá, {{$destinatario->name}},</p>
            <p>Estamos iniciando o processo de preenchimento do nosso relatório anual.</p>
            <p>Abaixo, seguem os campos de sua responsabilidade:</p>
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px;">Formulário</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Título</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Limite de caracteres</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{$secao->formulario->descricao}}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{$secao->descricao}}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{$secao->limite_caracteres}}</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <p>Atenciosamente,</p>
            <p>{{$remetente->name}}<br>
                Setor {{$remetente->setores()->pluck('name')->first()}}</p>
            <p>
                Favor confirmar o recebimento clicando no botão abaixo:
                <br>
                <a 
                    style="background-color: #fc914a; 
                        color: #f6f8fb; 
                        display: inline-block;
                        margin-top: 15px;
                        padding: 10px 15px;
                        text-align: center;
                        text-decoration: none;
                        font-weight: bold;
                        border-radius: 5px;"
                    href="{{route('sec_forms.confirmacao', [$destinatario->uuid, $secao->uuid])}}" role="button">Confirmar recebimento</a>
            </p>
        </div>
    </div>
    <div style="background-color: #fc914a; height: 30px;"></div>
</div>
