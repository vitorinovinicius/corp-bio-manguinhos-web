<script nonce="{{ csp_nonce() }}">
    //Busca CEP
    var $uf_cep = $("#uf").select2();
    $("#busca_cep").click(function(){
        var cep = $("#cep").val();
        $.ajax({
            type: "GET",
            url: "/admin/helper/get_address_rep/"+cep,
            beforeSend:function(){
                jQuery("#busca_cep").attr('disabled',true);
                jQuery(".cs-loading").show();
            },
            success: function (data){
                var data = $.parseJSON(data);
                if(data.resultado == 1){
                    //Escreve nos campos
                    $("#address").val(data.tipo_logradouro+" "+data.logradouro);
                    $("#district").val(data.bairro);
                    $("#city").val(data.cidade);
                    $("#uf").val(data.uf);
                    $uf_cep.val(data.uf).trigger("change"); //Seta o valor no select2
                    jQuery("#busca_cep").attr('disabled',false);
                    jQuery(".cs-loading").hide();
                }else{
                    alert(data.resultado_txt);
                    jQuery("#busca_cep").attr('disabled',false);
                    jQuery(".cs-loading").hide();
                }
            },
            error: function () {
                alert("Ocorreu um erro inesperado durante o processamento.");
                jQuery("#busca_cep").attr('disabled',false);
                jQuery(".cs-loading").hide();
            }
        });
        return false;
    });
</script>
