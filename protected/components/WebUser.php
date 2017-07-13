<?php
class WebUser extends CWebUser{
    public function getIsGuest(){
        $_id = $this->getState('__id');
        return empty($_id);
    }

}
