<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buscas extends CI_Controller
{

    public function index()
    {
        $this->load->helper('url');

        $this->load->view('verify');
        $this->load->view('header');
        $this->load->view('busca');
        $this->load->view('footer');
    }

    public function pontos()
    {
        $this->load->helper('url');
        $this->load->library('Pegakiapi');

        $this->load->view('verify');

        $cep = $this->input->post('cep');

        if(isset($cep)) {
            try {
                $token = $this->pegakiapi->authenticate();

                if(!$token)
                    throw new \Exception("Não foi possível resgatar o token");

                $resultados = $this->pegakiapi->getPontos($cep);

                if(!is_array($resultados))
                    throw new \Exception("Resultado não encontrado");

                echo '<div class="alert alert-success" role="alert">
                    Foram encontrado resultados para o cep '.$cep.'
                </div>';
                
            } catch (\Exception $e) {
                echo '<div class="alert alert-danger" role="alert">
                    '.$e->getMessage().'
                </div>';
            }
        }

        $this->load->view('header', ($resultados ? ['resultados' => $resultados] : []));

        $this->load->view('mapa', ($resultados ? ['resultados' => $resultados] : []));

        $this->load->view('busca');

        
        
        $this->load->view('footer');
    }

    public function porCep($cep) {
        
        $this->load->library('Pegakiapi');

        try {
            $token = $this->pegakiapi->authenticate();

            if(!$token)
                throw new \Exception("Não foi possível resgatar o token");

            $resultados = $this->pegakiapi->getPontos($cep);

            if(!is_array($resultados))
                throw new \Exception("Resultado não encontrado");
            
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function porArquivo($arquivo) {

        $this->load->library('Pegakiapi');

        echo "Arquivo :".$arquivo."\n";

        $arquivo_processado = str_replace(".", "_processado.", $arquivo);

        file_put_contents($arquivo_processado, "cep;resultado;\n");

        echo "Arquivo de Output :".$arquivo_processado."\n";

        try {

            $array = $this->openFile($arquivo);

            foreach($array as $cep) {

                // passo anterior a valida��o pois foi identificado que o arquivo possuía 7 dígitos (Faltando o zero inicial)
                $cep = $this->tratarCep($cep);

                if(!$this->verificaCep($cep)){
                    echo "Cep $cep inválido, pulando\n";
                    continue;
                } else {
                    echo "Verificando Cep $cep\n";
                }

                $resultados = $this->pegakiapi->getPontos($cep);

                foreach($resultados as $resultado) {

                    $endereco_string = $resultado->nome_fantasia." - ".$resultado->endereco.", ".$resultado->numero." - ".
                                        $resultado->bairro." ".$resultado->cidade." / ".$resultado->estado;

                    file_put_contents($arquivo_processado, $cep.";".utf8_decode($endereco_string).";\n", FILE_APPEND);
                }
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function tratarCep($cep) {

        if(strlen($cep) == 7) {
            return "0".$cep;
        }

        return $cep;
    }

    public function verificaCep($cep) {

        try {
                
            if(strlen($cep) <> 8) {
                throw new Exception("Cep n�o cont�m 8 d�gitos".strlen($cep));
            }
                
            return true;
        } catch(\Exception $e) {
            echo $e->getMessage()."\n";
        }
        return false;
    }

    private function openFile($filepath, $line_separation = "\n", $field_separation = null) {

        try {

            if(!file_exists($filepath)) {
                throw new \Exception("Arquivo $filepath n�o existe");
            }

            $file_string = file_get_contents(($filepath));

            if($line_separation) {
                $lines = explode($line_separation, $file_string);
            } else {
                throw new \Exception("Caractere de separa��o de linha n�o encontrado");
            }

            if($field_separation) {
                foreach($lines as $line) {
                    $fields[] = explode($field_separation, $line);
                }
            } else {
                $fields = $lines;
            }

            return $fields;
            
        } catch (\Exception $e) {
            throw new Exception("Erro ao abrir o arquivo: ".$e->getMessage()."\n");
        }
    }
}