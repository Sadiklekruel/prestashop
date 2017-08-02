<?php

class blog extends Module
{
    public function __construct()
    {
        $this->name = 'blog';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Yohann Doré';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Blog');
        $this->description = $this->l('Description of a blog.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('blog_NAME')) {
            $this->warning = $this->l('No name provided');
        }
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (!parent::install()
            || !$this->installDb()
            || !$this->addAdminTab()
        ) {
            return false;
        }

        return true;
    }

    public  function installDb()
	{
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blog` (
			`id_blog` int(11) NOT NULL auto_increment,
			`blog_name` varchar(50) NOT NULL,
			`blog_description` varchar(200) NOT NULL,
			`date_blog` datetime NOT NULL,
			PRIMARY KEY (`id_blog`))';
		return Db::getInstance()->execute($sql);
	}

    public function uninstallDb()
    {
        $sql = 'DROP TABLE '._DB_PREFIX_.'blog';
        return Db::getInstance()->execute($sql);
    }

    public function uninstall()
    {
        if (!parent::uninstall()
            || !Configuration::deleteByName('blog_NAME')
            || !$this->uninstallDb()
            || !$this->removeAdminTab()
        ) {
            return false;
        }

        return true;
    }

    public function addAdminTab()
    {
        // création de l'onglet
        $tab = new Tab();
        foreach(Language::getLanguages(false) as $lang)
            $tab->name[(int) $lang['id_lang']] = 'Blog';
        // Nom du controller sans le mot clé "Controller"
        $tab->class_name = 'AdminBlog';
        $tab->module = $this->name;
        $tab->id_parent = 0;
        if (!$tab->save())
            return false;
        return true;
    }

    // Suppression d'onglets
    public function removeAdminTab()
    {
        $classNames = array('admin_blog' => 'AdminBlog');
        $return = true;
        foreach ($classNames as $key => $className) {
            $tab = new Tab(Tab::getIdFromClassName($className));
            $return &= $tab->delete();
        }
        return $return;
    }
}
