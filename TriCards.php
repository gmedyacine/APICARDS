<?php

/**
 *  this class can request and sort the cards game
 *  @author gmedyacine
 */
class TriCards {

    protected $card;
    protected $url = array('get' => array('all-cards' => 'https://recrutement.local-trust.com/test/5991b15f975adeb8520a721b'),
        'post' => array('cards' => ''));

    protected $date_test;
    
    public function __construct() {
        $this->date_test= now();
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
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
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
    }

    public function excuteSortCards($cards) {
        
    }

    public function postSortedCards() {
        $methode = 'GET';
        $params = array();
        $url = $this->url['post']['cards'];
        $cards = $this->getCards();
        $cardsSorted = $this->excuteSortCards($cards);
        $params=array("cards"=>$cardsSorted);
        $this->creatResponse($methode, $url, $params);
    }

}
