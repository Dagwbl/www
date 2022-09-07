<?php

Class Site{
    private $sites = array(
        1=>'Taobao',
        2=>'Google',
        3=>'Runoob',
    );
    public function getAllSites(){
        return $this->sites;
    }

    public function getSite(){
        $site = array($id=>($this->sites[$id])?$this->sites[$id]:$this->sites[1]);
        return $site;
    }
}