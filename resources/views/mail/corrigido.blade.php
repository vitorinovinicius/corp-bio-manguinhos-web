<div style="font-family: 'Open Sans',sans-serif; font-size: 14px; line-height: 150%; color: #333; margin-top: 50px;  font-weight: normal;">
    <div  style="padding: 50px 10px 30px 50px;">
        {{-- <div style="position: relative; width: 100%; height: 20vh;">
            <img src="https://reari.uff.br/wp-content/uploads/sites/171/2023/09/fiocruz.png"
                 alt="Imagem" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" />
        </div> --}}
        <div style="padding-top: 70px;">

            <p>Olá, {{$destinatario->name}}!</p>
            <p>Gostaria de informar que foram realizadas as correções solicitadas e aguardo a análise.</p>
            <br>
            <p>Atenciosamente,</p>
            <p>{{$remetente->name}}<br>
            Setor {{$remetente->setores()->pluck('name')->first()}}</p>
            <p>Favor confirmar o recebimento clicando no botão abaixo<br>
                <a 
                    style="background-color: #fc914a; 
                        color: #f6f8fb; 
                        display:block;
                        width: 40%;
                        margin-top: 15px;
                        padding:10px 15px;
                        text-align: center;
                        text-decoration: none;
                        font-weight: bold;
                        border-radius:5px"
                    href="{{route('sec_forms.confirmacao', [$destinatario->uuid, $secao->uuid])}}" role="button">Confirmar recebimento</a>
            </p>
            <br>
        </div>
    </div>
    <div style="background-color: #fc914a; height: 30px;"></div>
</div>
