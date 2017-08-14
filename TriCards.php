<?php

namespace APICARDS;

/**
 *  this class can request and sort the cards game
 *  @author gmedyacine
 */
include 'Entites\Card.php';

class TriCards {

    protected $card;
    protected $url = array('get' => array('all-cards' => 'https://recrutement.local-trust.com/test/cards/57187b7c975adeb8520a283c'),
        'post' => array('cards' => 'https://recrutement.local-trust.com/test/'));
    protected $date_test;
    protected $exerciceId;
    protected $orderValue;
    protected $orderCateg;
    
    public function __construct() {
        $this->date_test = date("d.m.y");
    }

    /**
     * 
     * @param string $methode
     * @param string $url
     * @param string $params
     * @return mixed array 
     */
    private function creatResponse($methode, $url, $params = array()) {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $methode);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_PROXY, "");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json'
        ));

        $result = curl_exec($curl);
        if ($result === FALSE) {
            printf("cUrl error (#%d): %s<br>\n", curl_errno($curl), htmlspecialchars(curl_error($curl)));
            die();
        }

        $response = json_decode($result);
        if ($response) {
            return $response;
        } else {
            echo 'Error auth';
        }
    }

    public function getCards() {
        $methode = 'GET';
        $params = array();
        $url = $this->url['get']['all-cards'];
        $response = $this->creatResponse($methode, $url, $params);
        $data = $response->data;
        $this->exerciceId=$response->exerciceId;
        $this->orderCateg=$data->categoryOrder;
        $this->orderValue=$data->valueOrder;
        foreach ($data->cards as $card) {
            $cards[] = new Card($card->category,$card->value);
        }
       return $cards;  
    }

    public function excuteSortCards($cards) {
        usort($cards, function($a,$b){
            // oreder with category
            $cprCateg=strcmp(array_search($a->getCategory(),$this->orderCateg), array_search($b->getCategory(),$this->orderCateg)) ;
            // oreder with with value 
            $cprValue=strcmp(array_search($a->getValue(),$this->orderValue),array_search($b->getValue(),$this->orderValue)); 
            // si l'ordre category egaux en passe à la valeur
            return  $cprCateg!=0 ? $cprCateg : $cprValue;
        });
       return $cards; 
        }

    public function postSortedCards($cards) {
        $methode = 'POST';
        $cardJson=array();
        foreach ($cards as $card){
            $cardsJson[]=$card->jsonRender();
        }
        $params = array('cards'=>$cardsJson);
        $url = $this->url['post']['cards'].$this->exerciceId;
        $resultPost=$this->creatResponse($methode, $url,json_encode($params));
        return $resultPost;
    }

}
