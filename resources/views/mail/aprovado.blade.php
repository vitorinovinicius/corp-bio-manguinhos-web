<div style="font-family: 'Open Sans', sans-serif; font-size: 14px; line-height: 150%; color: #333; margin-top: 50px; font-weight: normal;">
    <div style="padding: 50px 10px 30px 50px;">
        <div style="padding-top: 70px;">
            <h2 style="color: #333; font-size: 24px; margin-bottom: 20px;">Aprovação de Campo de Relatório</h2>

            <p>Olá, {{ $destinatario->name }}!</p>
            <p>Estamos felizes em informar que o texto do seu campo no relatório foi aprovado! 🎉🎉🎉</p>
            <p>Agradecemos pelo seu trabalho e dedicação.</p>
            <p>Atenciosamente,<br>
                Setor de Conhecimento
            </p>           
            <p>Favor confirmar o recebimento clicando no botão abaixo:<br>
                <a style="background-color: #fc914a;
                        color: #f6f8fb;
                        display: block;
                        width: 40%;
                        margin-top: 15px;
                        padding: 10px 15px;
                        text-align: center;
                        text-decoration: none;
                        font-weight: bold;
                        border-radius: 5px;"
                    href="{{ route('sec_forms.confirmacao', $destinatario->uuid) }}" role="button">Confirmar recebimento</a>
            </p>
            <br>
        </div>
    </div>
    <div style="background-color: #fc914a; height: 30px;"></div>
</div>
