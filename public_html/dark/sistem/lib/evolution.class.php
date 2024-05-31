<?php

/*
 * @date: 13 may 2017
 * EvolutionGaming
*/

class Evolution {
    public $server      = 'apiprod.fundist.org';
    public $key         = '109e911ed10205e069295124d3916797';
    public $pass        = '1526723069138176';
    public $ip          = '188.138.32.224';
    public $currency    = 'TRY';
    public $language    = 'tr';
    public $tid;

    ##
    public $hash;
    public $method;
    public $fields;

    public function __construct() {
        $this->tid = uniqid('playgo');
    }

    public function getIp() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function userCreate($fields) {
        $query = [
            'Login'          => $fields['Login'],
            'Password'       => $fields['Password'],
            'TID'            => $this->tid,
            'Currency'       => $this->currency,
            'Language'       => $this->language,
            'RegistrationIP' => $_SERVER['REMOTE_ADDR']
        ];
        return $this->req(__FUNCTION__, $query);
    }

    public function getBalance($fields) {
        $query = [
            'Login' => $fields['Login'],
            'System' => '998',
            'TID' => $this->tid,
        ];
        return $this->req(__FUNCTION__, $query);
    }

    public function transfer($fields, $type) {
        $this->tid = md5(uniqid(__FUNCTION__).time());
        $query = [
            'Login'    => $fields['Login'],
            'System'   => '998',
            'Amount'   => $fields['Amount'],
            'TID'      => $this->tid,
            'Currency' => $this->currency,
            'Type'     => $type
        ];

        return $this->req(__FUNCTION__, $query);
    }

    public function getGames() {
        $query = [
            'TID' => $this->tid
        ];
        return $this->req(__FUNCTION__, $query);
    }

    public function getLobby($fields) {
        $query = [
            'Login' => $fields['Login'],
            'Password' => $fields['Password'],
            'System' => '998',
            'TID' => $this->tid,
            'Page' => 107,
            'UserIP' => $this->getIp()
        ];
        return $this->req(__FUNCTION__, $query);
    }

    public function getHash() {
        if ( $this->method == 'userCreate' )
        {
            return [
                'md5' => md5( 'User/Add/'.$this->ip.'/'.$this->tid.'/'.$this->key.'/'.$this->fields['Login'].'/'.$this->fields['Password'].'/'.$this->currency.'/' . $this->pass ),
                'endpoint' => 'User/Add'
            ];
        } else if ( $this->method == 'getBalance' ) {
            return [
                'md5' => md5( 'Balance/Get/'.$this->ip.'/'.$this->tid.'/'.$this->key.'/'.$this->fields['System'].'/'.$this->fields['Login'].'/' . $this->pass ),
                'endpoint' => 'Balance/Get'
            ];
        } else if ( $this->method == 'transfer' ) {
            return [
                'md5'      => md5( 'Balance/Set/'.$this->ip.'/'.$this->tid.'/'.$this->key.'/'.$this->fields['System'].'/'.$this->fields['Amount'].'/'.$this->fields['Login'].'/'.$this->fields['Currency'].'/' . $this->pass ),
                'endpoint' => 'Balance/Set'
            ];
        } else if ( $this->method == 'getGames' ) {
            return [
                'md5'   => md5( 'Game/List/'.$this->ip.'/'.$this->tid.'/'.$this->key.'/' . $this->pass ),
                'endpoint' => 'Game/List'
            ];
        } else if ( $this->method == 'getLobby' ) {
            return [
                'md5' => md5( 'User/DirectAuth/'.$this->ip.'/'.$this->tid.'/'.$this->key.'/'.$this->fields['Login'].'/'.$this->fields['Password'].'/'.$this->fields['System'].'/' . $this->pass ),
                'endpoint' => 'User/DirectAuth'
            ];
        }
    }

    public function req($method, $fields) {
        $this->method = $method;
        $this->fields = $fields;
        $this->hash = $this->getHash();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://' . $this->server . '/System/Api/' . $this->key . '/' . $this->hash['endpoint'] . '?&' . http_build_query( $this->fields ) . '&Hash=' . $this->hash['md5']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,  CURLOPT_CONNECTTIMEOUT, 5);
        $response = curl_exec($ch);

        return [
            'TID' => $this->tid,
            'response' => $response
        ];

    }

}
