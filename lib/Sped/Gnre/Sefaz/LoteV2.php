<?php

/**
 * Este arquivo é parte do programa GNRE PHP
 * GNRE PHP é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da Licença Pública Geral GNU como
 * publicada pela Fundação do Software Livre (FSF); na versão 2 da
 * Licença, ou (na sua opinião) qualquer versão.
 * Este programa é distribuído na esperança de que possa ser  útil,
 * mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer
 * MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU
 * junto com este programa, se não, escreva para a Fundação do Software
 * Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace Sped\Gnre\Sefaz;

use DOMDocument;

class LoteV2 extends Lote {

    public $ambienteDeTesteV2 = false;

    /**
     * @param bool $ambienteDeTesteV2
     * @return LoteV2
     */
    public function setAmbienteDeTesteV2(bool $ambienteDeTesteV2): LoteV2
    {
        $this->ambienteDeTesteV2 = $ambienteDeTesteV2;
        return $this;
    }

    public function getSoapEnvelop($gnre, $loteGnre)
    {
        $soapEnv = $gnre->createElement('soap12:Envelope');
        $soapEnv->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $soapEnv->setAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
        $soapEnv->setAttribute('xmlns:soap12', 'http://www.w3.org/2003/05/soap-envelope');

        $gnreCabecalhoSoap = $gnre->createElement('gnreCabecMsg');
        $gnreCabecalhoSoap->setAttribute('xmlns', 'http://www.gnre.pe.gov.br/wsdl/processar');
        $gnreCabecalhoSoap->appendChild($gnre->createElement('versaoDados', '2.00'));

        $soapHeader = $gnre->createElement('soap12:Header');
        $soapHeader->appendChild($gnreCabecalhoSoap);

        $soapEnv->appendChild($soapHeader);
        $gnre->appendChild($soapEnv);

        $action = $this->ambienteDeTesteV2 ?
            'http://www.testegnre.pe.gov.br/webservice/GnreLoteRecepcao' :
            'http://www.gnre.pe.gov.br/webservice/GnreLoteRecepcao';

        $gnreDadosMsg = $gnre->createElement('gnreDadosMsg');
        $gnreDadosMsg->setAttribute('xmlns', $action);

        $gnreDadosMsg->appendChild($loteGnre);

        $soapBody = $gnre->createElement('soap12:Body');
        $soapBody->appendChild($gnreDadosMsg);

        $soapEnv->appendChild($soapBody);
    }

    public function toXml() {
        $gnre = new DOMDocument('1.0', 'UTF-8');
        $gnre->formatOutput = false;
        $gnre->preserveWhiteSpace = false;

        $loteGnre = $gnre->createElement('TLote_GNRE');

        $loteXmlns = $gnre->createAttribute('xmlns');
        $loteXmlns->value = 'http://www.gnre.pe.gov.br';

        $loteVersao = $gnre->createAttribute('versao');
        $loteVersao->value = '2.00';

        $loteGnre->appendChild($loteVersao);
        $loteGnre->appendChild($loteXmlns);

        $guia = $gnre->createElement('guias');

        foreach ($this->getGuias() as $gnreGuia) {
            $estado = $gnreGuia->c01_UfFavorecida;
            $guiaEstado = $this->getEstadoFactory()->create($estado);
            $dados = $gnre->createElement('TDadosGNRE');
            $dadosVersao = $gnre->createAttribute('versao');
            $dadosVersao->value = '2.00';
            $dados->appendChild($dadosVersao);

            $ufFavorecida = $gnre->createElement('ufFavorecida', $estado);
            $tipoGnre = $gnre->createElement('tipoGnre', '0');
            $valorGNRE = $gnre->createElement('valorGNRE', $gnreGuia->c10_valorTotal);
            $dataPagamento = $gnre->createElement('dataPagamento', $gnreGuia->c33_dataPagamento);
            $identificadorGuia = $gnre->createElement('identificadorGuia', $gnreGuia->c42_identificadorGuia);

            $contribuinteEmitente = $gnre->createElement('contribuinteEmitente');

            $identificacao = $gnre->createElement('identificacao');
            if ($gnreGuia->c27_tipoIdentificacaoEmitente == parent::EMITENTE_PESSOA_JURIDICA) {
                $identificacaoChild = $gnre->createElement('CNPJ', $gnreGuia->c03_idContribuinteEmitente);
            } else {
                $identificacaoChild = $gnre->createElement('CPF', $gnreGuia->c03_idContribuinteEmitente);
            }
            $identificacao->appendChild($identificacaoChild);

            $razaoSocial = $gnre->createElement('razaoSocial', $gnreGuia->c16_razaoSocialEmitente);
            $endereco = $gnre->createElement('endereco', $gnreGuia->c18_enderecoEmitente);
            $municipio = $gnre->createElement('municipio', $gnreGuia->c19_municipioEmitente);
            $uf = $gnre->createElement('uf', $gnreGuia->c20_ufEnderecoEmitente);
            $cep = $gnre->createElement('cep', $gnreGuia->c21_cepEmitente);
            $telefone = $gnre->createElement('telefone', $gnreGuia->c22_telefoneEmitente);

            $contribuinteEmitente->appendChild($identificacao);
            $contribuinteEmitente->appendChild($razaoSocial);
            $contribuinteEmitente->appendChild($endereco);
            $contribuinteEmitente->appendChild($municipio);
            $contribuinteEmitente->appendChild($uf);
            $contribuinteEmitente->appendChild($cep);
            $contribuinteEmitente->appendChild($telefone);

            $itensGNRE = $gnre->createElement('itensGNRE');

            $item = $gnre->createElement('item');

            $receita = $gnre->createElement('receita', $gnreGuia->c02_receita);
            $documentoOrigem = $gnre->createElement('documentoOrigem', $gnreGuia->c04_docOrigem);
            $produto = $gnre->createElement('produto', $gnreGuia->c26_produto);
            $tipoDoc = $gnre->createAttribute('tipo');
            $tipoDoc->value = $gnreGuia->c28_tipoDocOrigem;
            $documentoOrigem->appendChild($tipoDoc);
            $referencia = $gnre->createElement('referencia');
            $periodo =  $gnre->createElement('periodo', '0');
            $referencia->appendChild($periodo);
            if ($gnreGuia->mes!=null) {
                $mes =  $gnre->createElement('mes', $gnreGuia->mes);
                $referencia->appendChild($mes);
            }
            if ($gnreGuia->ano!=null) {
                $ano =  $gnre->createElement('ano', $gnreGuia->ano);
                $referencia->appendChild($ano);
            }
            if ($gnreGuia->parcela!=null) {
                $parcela =  $gnre->createElement('parcela', $gnreGuia->parcela);
                $referencia->appendChild($parcela);
            }
            $dataVencimento = $gnre->createElement('dataVencimento', $gnreGuia->c14_dataVencimento);
            $valor11 = $gnre->createElement('valor', $gnreGuia->c06_valorPrincipal);
            $tipo11 = $gnre->createAttribute('tipo');
            $tipo11->value = '11';
            $valor11->appendChild($tipo11);
            $valor21 = $gnre->createElement('valor', $gnreGuia->c06_valorPrincipal);
            $tipo21 = $gnre->createAttribute('tipo');
            $tipo21->value = '21';
            $valor21->appendChild($tipo21);

            $contribuinteDestinatario = $gnre->createElement('contribuinteDestinatario');
            $identificacao = $gnre->createElement('identificacao');

            if ($gnreGuia->c34_tipoIdentificacaoDestinatario == parent::DESTINATARIO_PESSOA_JURIDICA) {
                $destinatarioContribuinteDocumento = $gnre->createElement('CNPJ', $gnreGuia->c35_idContribuinteDestinatario);
            } else {
                $destinatarioContribuinteDocumento = $gnre->createElement('CPF', $gnreGuia->c35_idContribuinteDestinatario);
            }
            $identificacao->appendChild($destinatarioContribuinteDocumento);
            if ($gnreGuia->c36_inscricaoEstadualDestinatario!='') {
                $IE = $gnre->createElement('IE', $gnreGuia->c36_inscricaoEstadualDestinatario);
                $identificacao->appendChild($IE);
            }
            $razaoSocial = $gnre->createElement('razaoSocial', $gnreGuia->c37_razaoSocialDestinatario);
            $municipio = $gnre->createElement('municipio', $gnreGuia->c38_municipioDestinatario);
            $contribuinteDestinatario->appendChild($identificacao);
            $contribuinteDestinatario->appendChild($razaoSocial);
            $contribuinteDestinatario->appendChild($municipio);

            $item->appendChild($receita);
            $item->appendChild($documentoOrigem);
            if ($gnreGuia->c26_produto != '') {
                $item->appendChild($produto);
            }
            $item->appendChild($referencia);
            $item->appendChild($dataVencimento);
            $item->appendChild($valor11);
            $item->appendChild($valor21);
            $item->appendChild($contribuinteDestinatario);

            $camposExtras = $this->gerarCamposExtras($gnre, $gnreGuia);
            if ($camposExtras != null) {
                $item->appendChild($camposExtras);
            }

            $itensGNRE->appendChild($item);

            $dados->appendChild($ufFavorecida);
            $dados->appendChild($tipoGnre);
            $dados->appendChild($contribuinteEmitente);
            $dados->appendChild($itensGNRE);
            $dados->appendChild($valorGNRE);
            $dados->appendChild($dataPagamento);
            $dados->appendChild($identificadorGuia);

            $guia->appendChild($dados);
            $gnre->appendChild($loteGnre);
            $loteGnre->appendChild($guia);
        }

        $this->getSoapEnvelop($gnre, $loteGnre);

        return $gnre->saveXML();
    }

    public function gerarCamposExtras($gnre, $gnreGuia) {
        if (is_array($gnreGuia->c39_camposExtras) && count($gnreGuia->c39_camposExtras) > 0) {
            $c39_camposExtras = $gnre->createElement('camposExtras');
            foreach ($gnreGuia->c39_camposExtras as $key => $campos) {
                $campoExtra = $gnre->createElement('campoExtra');
                $codigo = $gnre->createElement('codigo', $campos['campoExtra']['codigo']);
                $valor = $gnre->createElement('valor', $campos['campoExtra']['valor']);
                $campoExtra->appendChild($codigo);
                $campoExtra->appendChild($valor);
                $c39_camposExtras->appendChild($campoExtra);
            }
            return $c39_camposExtras;
        }
    }

    public function getCodigoDoc($uf, $difa = false) {
        $doc = '10';
        switch ($uf) {
            case 'AC' : $doc = '10'; break;//acre
            case 'AL' : $doc = '10'; break;//alagoas
            case 'AP' : $doc = '10'; break;//amapa
            case 'AM' : $doc = '22'; break;//amazon
            case 'BA' : $doc = '10'; break;
            case 'CE' : $doc = '10'; break;
            case 'DF' : $doc = '10'; break;
            case 'ES' : $doc = '10'; break;
            case 'GO' : $doc = '10'; break;
            case 'MA' : $doc = '10'; break;//maranhao
            case 'MT' : $doc = '10'; break;//mato grosso
            case 'MS' : $doc = '10'; break;//matro grosso sol
            case 'MG' : $doc = '10'; break;
            case 'PA' : $doc = '10'; break;//para
            case 'PB' : $doc = '10'; break;//paraiba
            case 'PR' : $doc = '10'; break;
            case 'PE' : $doc = $difa?'24':'22'; break;//pernan
            case 'PI' : $doc = '10'; break;//piaiu
            case 'RJ' : $doc = '24'; break;
            case 'RN' : $doc = '10'; break;
            case 'RS' : $doc = '22'; break;
            case 'RO' : $doc = '10'; break;//Rondonia
            case 'RR' : $doc = '10'; break;//Roraima
            case 'SC' : $doc = '24'; break;
            case 'SP' : $doc = '10'; break;
            case 'SE' : $doc = '10'; break;
            case 'TO' : $doc = '10'; break;
        }
        return $doc;
    }

    public function getNumDoc($uf) {
        $doc = 'numero';
        switch ($uf) {
            case 'AC' : $doc = 'numero'; break;//acre
            case 'AL' : $doc = 'numero'; break;//alagoas
            case 'AP' : $doc = 'numero'; break;//amapa
            case 'AM' : $doc = 'chave'; break;//amazon
            case 'BA' : $doc = 'numero'; break;
            case 'CE' : $doc = 'numero'; break;
            case 'DF' : $doc = 'numero'; break;
            case 'ES' : $doc = 'numero'; break;
            case 'GO' : $doc = 'numero'; break;
            case 'MA' : $doc = 'numero'; break;//maranhao
            case 'MT' : $doc = 'numero'; break;//mato grosso
            case 'MS' : $doc = 'numero'; break;//matro grosso sol
            case 'MG' : $doc = 'numero'; break;
            case 'PA' : $doc = 'numero'; break;//para
            case 'PB' : $doc = 'numero'; break;//paraiba
            case 'PR' : $doc = 'numero'; break;
            case 'PE' : $doc = 'chave'; break;//pernan
            case 'PI' : $doc = 'numero'; break;//piaiu
            case 'RJ' : $doc = 'chave'; break;
            case 'RN' : $doc = 'numero'; break;
            case 'RS' : $doc = 'chave'; break;
            case 'RO' : $doc = 'numero'; break;//Rondonia
            case 'RR' : $doc = 'numero'; break;//Roraima
            case 'SC' : $doc = 'chave'; break;
            case 'SP' : $doc = 'numero'; break;
            case 'SE' : $doc = 'numero'; break;
            case 'TO' : $doc = 'numero'; break;
        }
        return $doc;
    }

}