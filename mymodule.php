<?php
//création module prestashop 1.6

if(!defined('_PS_VERSION_'))
    exit;


class MyModule extends Module
{
    //declaration de la function constructeur et assignation des attributs
    public function __construct()
    {
        $this->name = 'mymodule';
        $this->tab = 'front_office_features';
        $this->version ='1.0';
        $this->author = 'Jérôme Ménétrier';
        $this->need_instance = 0;
        $this->ps_versions_compliancy= array('min'=>'1.5', 'max' =>_PS_VERSION_);

        parent::__construct();

        $this->dysplayName = $this->l('My module');
        $this->description = $this->l('Description of my module');
        $this->confirmUninstall = $this->l('are you surer you want to uninstall ?');
        if(!Configuration :: get('MYMODULE_NAME'))
        $this->warning =  $this->l('no name providded');
    }

    //declaration de la function install
    public function install()
    {/*verification de l'installation du module (true si correctement installé)*/
        if(parent::install()== false)
        {
            return false;
        }
        return true;

        /* ajout Version 1.5 pour la gestion boutiques*/
        if (Shop::isFeatureActive())
        {
            Shop::setcontext(Shop::CONTEXT_ALL);
        }

        /* rattacher aux 2 hook et declarer une var de config*/
        return parent::install() &&
            $this->registerHook('leftColumn') &&
            $this->registerHook('header') &&
            Configuration::updateValue('MYMODULE_NAME', 'my friend');

        /*si une de ces lignes échoue, l'installation n'a pas lieu*/
    }
    //déclaration de la fucntion uninstall qui supprime simplement la variable de configuration MYMODULE_NAME
    public function uninstall()
    {
        return parent::uninstall() && Configuration::deleteByName('MYMODULE_NAME');

        if(!parent::uninstall())
        {
            Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'mymoduleXXX');
            parent::uninstall();
        }
    }
}

?>