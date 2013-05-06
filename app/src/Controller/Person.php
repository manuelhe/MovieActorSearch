<?php
namespace Controller;

/**
 * Person Controller
 *
 * @author manuel.he@gmail.com
 */
class Person extends \Mas\Controller
{
    public function response() {
        if(!(isset($this->urlParams[0]) && intval($this->urlParams[0]))){
            $this->setAlert("Invalid Person ID");
            header("Location:".$this->config['config']['basePath']);
            return false;
        }
        $this->tmapi = $this->config['tmdb'];
        $personId = intval($this->urlParams[0]);

        //Set template
        $template = new \Mas\Template($this->config['config']['templatesDir']);
        $template->set_var('config', $this->config['config']);
        $template->set_var('alerts', $this->getAlerts());
        $template->set_var('person', $this->getPerson($personId));
        $template->set_var('credits', $this->getCredits($personId));
        echo $template->parse('person.tpl.php');
        $this->tmapi->close();
    }
    protected function getPerson($id){
        $response = $this->tmapi->apiPerson($id);
        if(isset($response->status_code) && isset($response->status_message)){
            $this->setAlert($response->status_message);
            header("Location:".$this->config['config']['basePath']);
            return false;
        }
        $response->profile_path = isset($response->profile_path) && $response->profile_path
                    ? $this->config['config']['tmdb']['image_base_url'].'w185'.$response->profile_path
                    : $this->config['config']['tmdb']['no_profile_image'];
        return $response;
    }
    protected function getCredits($id){
        $response = $this->tmapi->apiPersonCredits($id);
        if(!(isset($response->cast) && is_array($response->cast) && $response->cast)){
            return FALSE;
        }
        $ret = array();
        while(list($k,$v) = each($response->cast)){
            $v->title = isset($v->title) && trim($v->title) ? $v->title : 'Untitled';
            $v->mtitle = strlen($v->title) > 40 ? substr($v->title,0,38).'...' : $v->title;
            $v->poster_path = isset($v->poster_path) && $v->poster_path
                    ? $this->config['config']['tmdb']['image_base_url'].'w92'.$v->poster_path
                    : $this->config['config']['tmdb']['no_poster_image'];
            $v->character = isset($v->character) && trim($v->character) ? $v->character : 'Unnamed';
            $v->release_date = isset($v->release_date) && trim($v->release_date) ? $v->release_date : 'Undated';
            $ts = isset($v->release_date) && $v->release_date ? str_replace('-', '', $v->release_date) : $k;
            $ret[$ts] = $v;
        }
        ksort($ret);
        return $ret;
    }
}