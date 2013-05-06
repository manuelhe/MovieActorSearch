<?php
namespace Controller;

/**
 * Home Controller
 *
 * @author manuel.he@gmail.com
 */
class Home extends \Mas\Controller
{
    public function response() {
        $template = new \Mas\Template($this->config['config']['templatesDir']);
        $template->set_var('config', $this->config['config']);
        $template->set_var('alerts', $this->getAlerts());
        echo $template->parse('home.tpl.php');
    }
}
