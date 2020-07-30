<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegakiapi
{
    const SECRET_KEY = "83bc3861e96accc0defcae42488f5c632ec296cb335ebe3484a53405a165fd58";
    const API_URL = "https://api.pegaki.com.br/";
    const API_USER = "contato@pegaki.com.br";

    private $CI;
    private $token = false;

    private $results = false;

    public function __construct()
    {
        $this->CI = get_instance();
        $this->url = self::API_URL;
        $this->user_api = self::API_USER;
        $this->secret_key = self::SECRET_KEY;
    }

    public function authenticate() {

        if($this->token)
            return $this->token;
        
        $url = $this->url."authentication";
        $ch = curl_init($url);

        $data = json_encode(["email" => $this->user_api, "client_secret" => $this->secret_key]);
        
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type:application/json'
                ));
            
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
        $result = curl_exec($ch);
           
        curl_close($ch);

        if(!$json = json_decode($result))
            return false;

        if($json->id_token)
            return $this->token = $json->id_token;

        return false;
    }

    public function getPontos($cep, $limit = 10, $offset = 0) {

        if(!$this->token)
            $this->authenticate();
        
        $url = $this->url."pontos/".$cep;

        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type:application/json',
                    'Authorization:'.$this->token,
                    'X-Total-Limit: '.$limit,
                    'X-Total-Offset: '.$offset
                ));
            
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
        $result = curl_exec($ch);
           
        curl_close($ch);

        if(!$json = json_decode($result))
            return false;

        // var_dump([$this->token, $json]);

        if(isset($json->results) && $json->results)
            return $this->results = $json->results;

        return false;
    }

    public function getPontosForArray($arrayCep) {

        $pontos = array();

        try {
            if(!is_array($arrayCep))
                throw new \Exception("N�o foi poss�vel verificar a lista de CEPs");

            foreach($arrayCep as $cep) {
                
                $getResult = $this->getPontos($cep);

                if($getResult) {
                    $pontos[] = ["cep" => $cep, "resultados" => $getResult];
                }
            }

        } catch (Exception $e) {
            echo "Erro ao verificar os pontos: ".$e->getMessage();
        }
        
    }
}