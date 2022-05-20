<html>
    <meta charset="UTF-8"/>
    <style type="text/css">
        @page { 
            margin: 5px;
            padding:0px;
        }
        body{
            margin:5px;
            padding:0px;
            font-size: 0.54rem;
            font-family: sans-serif;
        }
        table tr td{
            border: 1px solid #000;
        }
        .columnone{
            width: 400px;
        }
        .gnre{
            font-size: 14px;
            height:23px;
            font-weight:bold;
            text-align: center;
        }
        .noborder{
            border-top: 0px;
            border-bottom: 0px;
            border-left: 0px;
            border-right: 0px;
        }
        .center{
            text-align: center;
        }
        .nobrdtb{
            border-top: 0px;
            border-bottom: 0px;
        }
        .noleft{
            border-left: 0px;
        }

        .nobottom{
            border-bottom: 0px;
        }
        .notop{
            border-top: 0px;
        }

        .noright{
            border-right: 0px;
        }

        .borderleft{
            border-top: 0px;
            border-bottom: 0px;
            border-right: 0px;
        }

        .borderbottom{
            border-top: 0px;
            border-left: 0px;
            border-right: 0px;
        }

        .borderright{
            border-top: 0px;
            border-bottom: 0px;
            border-left: 0px;
        }

    </style>
    <body>
        {foreach $guiaViaInfo as $key => $via}
            <table cellspacing="0" cellpadding="1" style="width:100%;">
                <tr>
                    <td style="width:65%;" valign="top" class="noborder">
                        <table cellspacing="0" cellpadding="1" style="width:700px;">
                            <tr>
                                <td class="columnone gnre" colspan="2">
                                    Guia Nacional de Recolhimento de Tributos Estaduais - GNRE
                                </td>
                            </tr>
                            <tr>
                                <td class="center nobrdtb" colspan="2">
                                    <strong>Dados do emitente</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="borderleft">
                                    <strong>Razão Social</strong>
                                </td>
                                <td class="borderright" style="width: 100px">
                                    <strong>CNPJ/CPF/Insc. Est.</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="borderleft">
                                    {$guia->c16_razaoSocialEmitente}
                                </td>
                                <td class="borderright">
                                    {$guia->c03_idContribuinteEmitente}
                                </td>
                            </tr>
                            <tr>
                                <td class="notop nobottom" colspan="2">
                                    <strong>Endereço:</strong> {$guia->c18_enderecoEmitente}
                                </td>
                            </tr>
                            <tr>
                                <td class="borderleft">
                                    <strong>Município:</strong> {$guia->c19_municipioEmitente}
                                </td>
                                <td class="borderright">
                                    <strong>UF:</strong> {$guia->c20_ufEnderecoEmitente}
                                </td>
                            </tr>
                            <tr>
                                <td class="noright notop">
                                    <strong>CEP:</strong> {$guia->c21_cepEmitente}
                                </td>
                                <td class="noleft notop">
                                    <strong>Telefone:</strong> {$guia->c22_telefoneEmitente}
                                </td>
                            </tr>
                            <tr >
                                <td class="center nobrdtb" colspan="2">
                                    <strong>Dados do Destinatário</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="notop nobottom" colspan="2">
                                    <strong>CNPJ/CPF/Insc. Est.:</strong> {$guia->c35_idContribuinteDestinatario}
                                </td>
                            </tr>
                            <tr>
                                <td class="notop" colspan="2">
                                    <strong>Município:</strong> {$guia->c38_municipioDestinatario}
                                </td>
                            </tr>
                            <tr>
                                <td class="center nobrdtb" colspan="2">
                                    <strong>Informações à Fiscalização</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="notop nobottom" colspan="2">
                                    <strong>Convênio/Protocolo:</strong> {$guia->c15_convenio}
                                </td>
                            </tr>
                            <tr>
                                <td class="notop" colspan="2" style="height:20px">
                                    <strong>Produto:</strong> {$guia->c26_produto}
                                </td>
                            </tr>
                            <tr>
                                <td class="nobrdtb" colspan="2" style="height:56px" valign="top">
                                    <strong>Informações Complementares:</strong> {$guia->retornoInformacoesComplementares}
                                </td>
                            </tr>
                            <tr>
                                <td class="notop" colspan="2">
                                    <strong>Documento válido para pagamento até</strong> {$guia->c14_dataVencimento}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="noborder" valign="top">
                        <table cellspacing="0" cellpadding="1" style="width:100%; margin-left: -1px;">
                            <tr>
                                <td class="nobottom"><strong>UF Favorecida</strong></td>
                                <td style="width: 120px" colspan="2" class="nobottom"><strong>Código da Receita</strong></td>
                            </tr>
                            <tr>
                                <td class="notop" align="right">{$guia->c01_UfFavorecida}</td>
                                <td class="notop" align="right" colspan="2">{$guia->c02_receita}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="nobottom"><strong>Nº de Controle</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right" class="notop">{$guia->retornoNumeroDeControle}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="nobottom"><strong>Data de Vencimento</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right" class="notop">{$guia->c14_dataVencimento}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="nobottom"><strong>Nº do Documento de Origem</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right" class="notop">{$guia->c04_docOrigem}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="nobottom"><strong>Período de Referência</strong></td>
                                <td class="nobottom" align="left"><strong>Nº Parcela</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="notop" align="right">{$guia->mes / $guia->ano}</td>
                                <td class="notop" align="right">{$guia->parcela}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="nobottom"><strong>Valor Principal</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="notop" align="right">R$ {$guia->c06_valorPrincipal}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="nobottom"><strong>Atualização Monetária</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="notop" align="right">R$ {$guia->retornoAtualizacaoMonetaria}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="nobottom"><strong>Juros</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="notop" align="right">R$ {$guia->retornoJuros}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="nobottom"><strong>Multa</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="notop" align="right">R$ {$guia->retornoMulta}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="nobottom"><strong>Total a Recolher</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="notop" align="right">{$guia->c10_valorTotal}</td>
                            </tr>
                            <tr>
                                <td class="noborder" colspan="3" style="text-align:right;">{$via}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="noborder" style="padding-left:35px">
                        {$guia->retornoRepresentacaoNumerica}
                    </td>
                </tr>
                <tr>
                    <td class="noborder">
                        <img src="data:image/jpeg;base64,{$barcode->getCodigoBarrasBase64()}"/>
                    </td>
                </tr>
            </table>
            <br/>
        {/foreach}
    </body>
</html>